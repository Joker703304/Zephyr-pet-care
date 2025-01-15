<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\konsultasi;
use App\Models\obat;
use App\Models\Dokter;
use App\Models\ResepObat;
use App\Models\Layanan;
use Carbon\Carbon;
use App\Models\DetailResepObat;
use App\Models\DokterJadwal;
use Illuminate\Support\Facades\Auth;

class DokterDashboardController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya pemilik hewan yang dapat mengakses
        $this->middleware('role:dokter');
    }

    public function index()
{
    // Cek role pengguna yang sedang login
    if (auth()->user()->role == 'dokter') {
        // Ambil data pemilik hewan terkait dengan user yang login
        $userId = auth()->user()->id;

        // Ambil data pemilik hewan berdasarkan user_id
        $data = Dokter::with('user')
            ->where('id_user', $userId)
            ->get();

        // Tampilkan view untuk pemilik hewan
        return view('dokter.index', compact('data'));
    }

    // Jika role adalah admin, ambil semua data pemilik hewan
    $data = Dokter::with('user')->get();

    // Tampilkan view untuk admin
    return view('admin.pemilik_hewan.index', compact('data'));
}

    public function dokter()
    {
          // Check if the logged-in user has a doctor profile
          $dokter = Dokter::where('id_user', Auth::id())->first();

          // Retrieve the schedules from the database
    $schedules = DokterJadwal::all();  // Or your sp

          if (!$dokter) {
              // If no doctor profile exists, redirect to the profile creation page
              return redirect()->route('dokter.createProfile')->with('warning', 'Mohon Isi data diri terlebih dahulu.');
          }

          $today = now()->toDateString(); // Mendapatkan tanggal hari ini

    $countPerawatan = Konsultasi::where('dokter_id', $dokter->id)
        ->where('status', 'Diterima')
        ->whereDate('tanggal_konsultasi', $today)
        ->count();

        $currentMonth = now()->month; // Mendapatkan bulan saat ini
        $currentYear = now()->year;  // Mendapatkan tahun saat ini
    
        $jadwalBulanIni = DokterJadwal::where('id_dokter', $dokter->id)
            ->whereMonth('tanggal', $currentMonth) // Filter berdasarkan bulan
            ->whereYear('tanggal', $currentYear)  // Filter berdasarkan tahun
            ->count();
  
        // Menampilkan tampilan dashboard pemilik hewan
        return view('dokter.dashboard', compact('schedules', 'countPerawatan', 'jadwalBulanIni'));
    }

    public function konsultasi()
{
    $today = Carbon::today();

    // Filter konsultasi untuk menampilkan hanya yang memiliki tanggal hari ini atau yang akan datang
    $konsultasi = Konsultasi::with(['hewan', 'dokter', 'resepObat'])
        ->whereDate('tanggal_konsultasi', '>=', $today) // Menampilkan konsultasi hari ini atau yang akan datang
        ->where('status', 'Diterima') // Filter dengan status 'Diterima'
        ->orWhere('status', 'Pembuatan Obat') // Sertakan konsultasi dengan status 'Pembuatan Obat'
        ->get();

    return view('dokter.konsultasi', compact('konsultasi'));
}


    public function diagnosis($id)
    {
        $konsultasi = Konsultasi::with(['hewan', 'dokter', 'resepObat'])->findOrFail($id);
        $obat = Obat::all();
        $layanan = Layanan::all();

        return view('dokter.diagnosis', compact('konsultasi', 'obat', 'layanan'));
    }

    public function storeDiagnosis(Request $request, $id_konsultasi)
{
    $konsultasi = Konsultasi::findOrFail($id_konsultasi);

    // Update diagnosis dan status
    $konsultasi->update([
        'diagnosis' => $request->diagnosis,
        'status' => 'Pembuatan Obat',  // Ubah status menjadi Pembuatan Obat
    ]);

    // Hapus layanan lama
    $konsultasi->layanan()->detach(); // Menghapus relasi lama

    // Menambahkan layanan baru yang dipilih
    if ($request->has('layanan_id')) {
        $konsultasi->layanan()->attach($request->layanan_id);
    }

    // Hapus resep obat yang dihapus oleh user
    if ($request->filled('deleted_obat_ids')) {
        $deletedIds = explode(',', $request->deleted_obat_ids);
        
        // Hapus dari tabel resep_obat
        ResepObat::whereIn('id_resep', $deletedIds)->delete();
        
        // Hapus juga dari tabel detail_resep_obat
        DetailResepObat::whereIn('id_resep', $deletedIds)->delete();
    }

    // Update atau Tambahkan resep obat baru
    if ($request->has('obat')) {
        foreach ($request->obat as $key => $data) {
            if (str_starts_with($key, 'new')) {
                // Tambahkan resep obat baru
                $resep = ResepObat::create([
                    'id_konsultasi' => $konsultasi->id_konsultasi,
                    'id_obat' => $data['id_obat'],
                    'jumlah' => $data['jumlah'],
                ]);

                // Kurangi stok obat sesuai jumlah yang diberikan
                $obat = Obat::findOrFail($data['id_obat']);
                $obat->stok -= $data['jumlah']; // Kurangi stok
                $obat->save(); // Simpan perubahan stok

                // Tambahkan detail resep baru
                DetailResepObat::create([
                    'id_resep' => $resep->id_resep,
                    'id_obat' => $data['id_obat'],
                    'tanggal_resep' => now(),
                    'status' => 'belum_diberikan',
                ]);
            } else {
                // Update resep obat yang ada
                ResepObat::where('id_resep', $key)->update([
                    'id_obat' => $data['id_obat'],
                    'jumlah' => $data['jumlah'],
                ]);

                // Update stok obat
                $obat = Obat::findOrFail($data['id_obat']);
                $stokLama = ResepObat::find($key)->jumlah;
                $obat->stok += $stokLama - $data['jumlah']; // Mengembalikan stok lama, kemudian mengurangi stok baru
                $obat->save();

                // Update detail resep
                DetailResepObat::where('id_resep', $key)->update([
                    'id_obat' => $data['id_obat'],
                ]);
            }
        }
    }

    return redirect()->route("dokter.konsultasi.index")->with('success', 'Diagnosis dan resep berhasil diperbarui.');
}


public function deleteExpiredConsultations()
{
    $today = Carbon::today();

    // Hapus konsultasi yang sudah lewat dan memiliki status 'Pembuatan Obat'
    Konsultasi::whereDate('tanggal_konsultasi', '<', $today)
        ->where('status', 'Pembuatan Obat')
        ->delete();

    return redirect()->route("dokter.konsultasi.index")->with('success', 'Konsultasi yang sudah lewat telah dihapus.');
}

    public function createProfile()
    {
        return view('dokter.createProfile');
    }

    public function storeProfile(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'spesialis' => 'required|string|max:50',
            'no_telepon' => 'required|string|max:20|unique:tbl_dokter',
            'jenkel' => 'required|in:pria,wanita',
            'alamat' => 'nullable|string',
        ]);

        // Create a new doctor profile
        Dokter::create([
            'id_user' => Auth::id(),
            'spesialis' => $validated['spesialis'],
            'no_telepon' => $validated['no_telepon'],
            'jenkel' => $validated['jenkel'],
            'alamat' => $validated['alamat'],
        ]);

        // Redirect to the dashboard after the profile is created
        return redirect()->route('dokter.dashboard')->with('success', 'Your profile has been created successfully.');
    }

    public function editProfile()
    {
        // Get the doctor's profile
        $dokter = Dokter::where('id_user', Auth::id())->first();

        // Return the profile edit view with the doctor's current data
        return view('dokter.editProfile', compact('dokter'));
    }

    public function updateProfile(Request $request)
{
    // Validate the incoming data
    $validated = $request->validate([
        'name' => 'required|string|max:255',  // Menambahkan validasi untuk name
        'spesialis' => 'required|string|max:50',
        'no_telepon' => 'required|string|max:20|unique:tbl_dokter,no_telepon,' . Auth::id() . ',id_user',
        'jenkel' => 'required|in:pria,wanita',
        'alamat' => 'nullable|string',
    ]);

    // Temukan dokter berdasarkan id_user (auth)
    $dokter = Dokter::where('id_user', Auth::id())->first();

    // Update nama pengguna
    $dokter->user->update([
        'name' => $validated['name'],
    ]);

    // Update data dokter
    $dokter->update([
        'spesialis' => $validated['spesialis'],
        'no_telepon' => $validated['no_telepon'],
        'jenkel' => $validated['jenkel'],
        'alamat' => $validated['alamat'],
    ]);

    // Redirect to the dashboard after the profile is updated
    return redirect()->route('dokter.dashboard')->with('success', 'Profile Anda Berhasil Di Perbarui.');
}

    
}