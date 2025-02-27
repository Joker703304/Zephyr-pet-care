<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\konsultasi;
use App\Models\obat;
use App\Models\Dokter;
use App\Models\ResepObat;
use App\Models\Layanan;
use App\Models\Antrian;
use Carbon\Carbon;
use App\Models\DetailResepObat;
use App\Models\DokterJadwal;
use App\Models\pemilik_hewan;
use App\Models\Hewan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

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

    public function panggil(Request $request, Antrian $antrian)
    {
        $antrian->update(['status' => 'Dipanggil']);

        // Ambil data konsultasi terkait antrian
        $konsultasi = $antrian->konsultasi;
        $hewan = Hewan::find($konsultasi->id_hewan);
        $pemilik = pemilik_hewan::where('id_pemilik', $hewan->id_pemilik)->first();

        if ($pemilik) {
            $nomorPemilik = $pemilik->user->phone; // Ambil nomor HP pemilik dari tabel users
            $apiToken = 'API-TOKEN-3Kf4h51x2zIfh2Si2fd8LMorPfs5T9JXKiqYv1dnaT1hvwMWXs8crl';
            $gateway = '6288229193849';

            $pesan = "📢 *Pemanggilan Pasien* 📢\n\n"
                . "🐶 Hewan: {$hewan->nama_hewan}\n"
                . "📅 Tanggal Konsultasi: {$konsultasi->tanggal_konsultasi}\n"
                . "📌 No. Antrian: {$konsultasi->no_antrian}\n\n"
                . "🔔 *Giliran Anda telah tiba! Harap segera menuju ruang pemeriksaan.*";

            Http::withToken($apiToken)->post('http://app.japati.id/api/send-message', [
                'gateway' => $gateway,
                'number' => $nomorPemilik,
                'type' => 'text',
                'message' => $pesan,
            ]);
        }

        return redirect()->back()->with('success', 'Pasien telah dipanggil dan notifikasi telah dikirim ke WhatsApp.');
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
            ->where('status', 'Praktik')
            ->count();

        // Menampilkan tampilan dashboard pemilik hewan
        return view('dokter.dashboard', compact('schedules', 'countPerawatan', 'jadwalBulanIni'));
    }

    public function konsultasi()
    {
        $today = Carbon::today();

        // Ambil dokter yang sedang login
        $dokter = Dokter::where('id_user', Auth::id())->first();

        if (!$dokter) {
            // Jika dokter tidak ditemukan, arahkan ke halaman profil
            return redirect()->route('dokter.createProfile')->with('warning', 'Mohon isi data diri terlebih dahulu.');
        }

        // Filter konsultasi berdasarkan dokter yang sedang login dan tanggal hari ini
        $konsultasi = Konsultasi::with(['hewan', 'dokter', 'resepObat'])
            ->where('dokter_id', $dokter->id) // Filter by dokter ID
            ->whereDate('tanggal_konsultasi', $today) // Filter by today's date
            ->where('status', 'Diterima') // Filter by status 'Diterima'
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
                    // $obat->stok -= $data['jumlah']; // Kurangi stok
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

        // Kirim notifikasi ke apoteker dan pemilik
        $apiToken = 'API-TOKEN-3Kf4h51x2zIfh2Si2fd8LMorPfs5T9JXKiqYv1dnaT1hvwMWXs8crl';
        $gateway = '6288229193849';

        $apoteker = User::where('role', 'apoteker')->first();
        $pemilik = $konsultasi->hewan->pemilik;

        if ($apoteker) {
            $nomorApoteker = $apoteker->phone; // Gunakan nomor dari tabel users
            $pesanApoteker = "Halo {$apoteker->name},\nDiagnosis baru dibuat untuk {$konsultasi->hewan->nama_hewan}. Silakan persiapkan obatnya.";

            Http::withToken($apiToken)->post('http://app.japati.id/api/send-message', [
                'gateway' => $gateway,
                'number' => $nomorApoteker,
                'type' => 'text',
                'message' => $pesanApoteker,
            ]);
        }

        if ($pemilik) {
            $nomorPemilik = $pemilik->user->phone;
            $pesanPemilik = "Halo {$pemilik->user->name},\nHasil diagnosis hewan Anda ({$konsultasi->hewan->nama_hewan}): {$konsultasi->diagnosis}.\nStatus: Pembuatan Obat. Obat sedang disiapkan oleh apoteker {$apoteker->name}. Silahkan tunggu informasi selanjutnya.";

            Http::withToken($apiToken)->post('http://app.japati.id/api/send-message', [
                'gateway' => $gateway,
                'number' => $nomorPemilik,
                'type' => 'text',
                'message' => $pesanPemilik,
            ]);
        }

        return redirect()->route("dokter.konsultasi.index")->with('success', 'Diagnosis dan resep berhasil diperbarui.');
    }

    // public function deleteExpiredConsultations()
    // {
    //     $today = Carbon::today();

    //     // Hapus konsultasi yang sudah lewat dan memiliki status 'Pembuatan Obat'
    //     Konsultasi::whereDate('tanggal_konsultasi', '<', $today)
    //         ->where('status', 'Pembuatan Obat')
    //         ->delete();

    //     return redirect()->route("dokter.konsultasi.index")->with('success', 'Konsultasi yang sudah lewat telah dihapus.');
    // }

    public function createProfile()
    {
        $user = auth()->user();
        return view('dokter.createProfile', compact('user'));
    }

    public function storeProfile(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'spesialis' => 'required|string|max:50',
            'phone' => 'required|string|max:13|exists:users,phone',
            'jenkel' => 'required|in:pria,wanita',
            'alamat' => 'nullable|string',
        ]);

        // Create a new doctor profile
        Dokter::create([
            'id_user' => Auth::id(),
            'spesialis' => $validated['spesialis'],
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
            'jenkel' => $validated['jenkel'],
            'alamat' => $validated['alamat'],
        ]);

        // Redirect to the dashboard after the profile is updated
        return redirect()->route('dokter.dashboard')->with('success', 'Profile Anda Berhasil Di Perbarui.');
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $dokter = Dokter::findOrFail($id); // Pastikan model sesuai
        $dokter->user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diperbarui.');
    }
}
