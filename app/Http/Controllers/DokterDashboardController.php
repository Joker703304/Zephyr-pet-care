<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\konsultasi;
use App\Models\obat;
use App\Models\ResepObat;
use App\Models\Layanan;
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
        // Menampilkan tampilan dashboard pemilik hewan
        return view('dokter.dashboard');
    }

    public function konsultasi()
    {
        $konsultasi = Konsultasi::with(['hewan', 'dokter', 'resepObat'])->get();
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
        'layanan_id' => $request->layanan_id
    ]);

    // Hapus resep obat yang dihapus oleh user
    if ($request->filled('deleted_obat_ids')) {
        $deletedIds = explode(',', $request->deleted_obat_ids);
        ResepObat::whereIn('id_resep', $deletedIds)->delete();
    }

    // Update atau Tambahkan resep obat baru
    if ($request->has('obat')) {
        foreach ($request->obat as $key => $data) {
            if (str_starts_with($key, 'new')) {
                // Tambahkan resep obat baru
                ResepObat::create([
                    'id_konsultasi' => $konsultasi->id_konsultasi, // Pastikan id_konsultasi diisi
                    'id_obat' => $data['id_obat'],
                    'jumlah' => $data['jumlah'],
                ]);
            } else {
                // Update resep obat yang ada
                ResepObat::where('id_resep', $key)->update([
                    'id_obat' => $data['id_obat'],
                    'jumlah' => $data['jumlah'],
                ]);
            }
        }
    }
    

    return redirect()->back()->with('success', 'Diagnosis dan resep berhasil diperbarui.');
}



}
