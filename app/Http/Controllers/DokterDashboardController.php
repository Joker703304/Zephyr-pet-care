<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\konsultasi;
use App\Models\obat;
use App\Models\ResepObat;
use App\Models\Layanan;
use App\Models\Dokter;
use Carbon\Carbon;
use App\Models\DetailResepObat;
use Illuminate\Support\Facades\Auth;

class DokterDashboardController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya pemilik hewan yang dapat mengakses
        $this->middleware('role:dokter');
    }

    public function dokter()
    {
        // Check if the logged-in user has a doctor profile
        $dokter = Dokter::where('id_user', Auth::id())->first();

        if (!$dokter) {
            // If no doctor profile exists, redirect to the profile creation page
            return redirect()->route('dokter.createProfile')->with('warning', 'Please complete your profile first.');
        }

        // Return the dashboard view if the doctor profile exists
        return view('dokter.dashboard');
    }

    public function konsultasi()
    {
        $today = Carbon::today();

        // Filter konsultasi to show only those with today's date
        $konsultasi = Konsultasi::with(['hewan', 'dokter', 'resepObat'])
            ->whereDate('tanggal_konsultasi', $today) // Filter by today's date
            ->where('status', 'Sedang Perawatan')
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

    // Update diagnosis dan layanan
    $konsultasi->update([
        'diagnosis' => $request->diagnosis,
        'layanan_id' => $request->layanan_id,
        'status' => 'Pembuatan Obat',
    ]);

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
                    'id_konsultasi' => $konsultasi->id_konsultasi, // Pastikan id_konsultasi diisi
                    'id_obat' => $data['id_obat'],
                    'jumlah' => $data['jumlah'],
                ]);

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

                // Update detail resep
                DetailResepObat::where('id_resep', $key)->update([
                    'id_obat' => $data['id_obat'],
                ]);
                
            }
        }
    }

    return redirect()->route("dokter.konsultasi.index")->with('success', 'Diagnosis dan resep berhasil diperbarui.');
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
    return redirect()->route('dokter.dashboard')->with('success', 'Your profile has been updated successfully.');
}


}
