<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\konsultasi;
use App\Models\obat;
use App\Models\ResepObat;
use App\Models\Layanan;
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
        // Menampilkan tampilan dashboard pemilik hewan
        return view('dokter.dashboard');
    }

    public function konsultasi()
    {
        $today = Carbon::today();

        // Filter konsultasi to show only those with today's date
        $konsultasi = Konsultasi::with(['hewan', 'dokter', 'resepObat'])
            ->whereDate('tanggal_konsultasi', $today) // Filter by today's date
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
        'layanan_id' => $request->layanan_id
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

}
