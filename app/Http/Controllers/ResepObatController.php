<?php

namespace App\Http\Controllers;

use App\Models\ResepObat;
use App\Models\konsultasi;
use App\Models\Transaksi;
use App\Models\obat;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ResepObatController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->role == 'pemilik_hewan') {
            // Ambil id_konsultasi yang sesuai
            $idKonsultasiSiap = ResepObat::where('status', 'siap')
                ->whereHas('konsultasi', function ($query) use ($user) {
                    $query->whereIn('id_hewan', function ($subQuery) use ($user) {
                        $subQuery->select('id_hewan')
                            ->from('hewan')
                            ->where('id_pemilik', $user->pemilikHewan->id_pemilik);
                    });
                })
                ->pluck('id_konsultasi')
                ->unique();

            // Paginasi
            $perPage = 6;
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $paginatedIds = $idKonsultasiSiap->forPage($currentPage, $perPage)->values();

            // Ambil resep berdasarkan id_konsultasi
            $resep_obat_all = ResepObat::whereIn('id_konsultasi', $paginatedIds)
                ->where('status', 'siap')
                ->with('konsultasi.hewan', 'obat')
                ->get()
                ->groupBy('id_konsultasi');

            // Buat paginator instance
            $resep_obat = new LengthAwarePaginator(
                $resep_obat_all,
                $idKonsultasiSiap->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            return view('pemilik-hewan.resep_obat.index', compact('resep_obat'));
        }
    }


    public function history()
    {
        // Ambil semua resep yang statusnya sudah siap
        $resep_obat = ResepObat::where('status', 'siap') // Hanya yang sudah siap
            ->with('konsultasi', 'obat')
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('id_konsultasi'); // Kelompokkan berdasarkan konsultasi

        return view('apoteker.resep_obat.history', compact('resep_obat'));
    }

    public function create()
    {
        $konsultasi = konsultasi::all();
        $obat = obat::all();
        return view('apoteker.resep_obat.create', compact('konsultasi', 'obat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_konsultasi' => 'required|exists:konsultasi,id_konsultasi',
            'obat' => 'required|array',
            'obat.*.id_obat' => 'required|exists:obat,id_obat',
            'obat.*.jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        foreach ($request->obat as $obat) {
            ResepObat::create([
                'id_konsultasi' => $request->id_konsultasi,
                'id_obat' => $obat['id_obat'],
                'jumlah' => $obat['jumlah'],
                'keterangan' => $request->keterangan,
            ]);
        }

        return redirect()->route('apoteker.resep_obat.index')->with('success', 'Resep obat berhasil ditambahkan.');
    }

    public function edit($id_konsultasi)
    {
        // Ambil semua resep terkait konsultasi
        $resepGroup = ResepObat::where('id_konsultasi', $id_konsultasi)->get();

        if ($resepGroup->isEmpty()) {
            return redirect()->route('apoteker.resep_obat.index')->with('error', 'Resep tidak ditemukan.');
        }

        // Data tambahan untuk dropdown
        $konsultasi = Konsultasi::all(); // Semua data konsultasi
        $obat = Obat::all(); // Semua data obat

        return view('apoteker.resep_obat.edit', compact('resepGroup', 'konsultasi', 'obat', 'id_konsultasi'));
    }

    public function update(Request $request, $id_konsultasi)
    {
        $request->validate([
            'id_obat' => 'required|array|min:1',
            'id_obat.*' => 'exists:obat,id_obat',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'keterangan' => 'required|array', // Keterangan wajib diisi sebagai array
            'keterangan.*' => 'required|string|max:255', // Validasi tiap keterangan harus wajib diisi
            'status' => 'nullable|string|in:sedang disiapkan,siap',
        ], [
            'keterangan.*.required' => 'Keterangan pada setiap obat wajib diisi.', // Pesan kesalahan khusus
        ]);

        // Hapus semua resep lama terkait konsultasi ini
        ResepObat::where('id_konsultasi', $id_konsultasi)->delete();

        $totalHargaObat = 0;

        foreach ($request->id_obat as $index => $id_obat) {
            $jumlah = $request->jumlah[$index];
            $keterangan = $request->keterangan[$index];

            // Ambil data obat dan validasi stok
            $obat = Obat::find($id_obat);
            if ($obat) {
                if ($obat->stok < $jumlah) {
                    return redirect()->back()->withErrors(['stok' => "Stok obat {$obat->nama_obat} tidak mencukupi."]);
                }

                $obat->stok -= $jumlah;
                $obat->save();

                // Hitung subtotal untuk obat ini
                $subtotal = $obat->harga * $jumlah;
                $totalHargaObat += $subtotal;
            }

            // Simpan resep obat dengan keterangan per obat
            ResepObat::create([
                'id_konsultasi' => $id_konsultasi,
                'id_obat' => $id_obat,
                'jumlah' => $jumlah,
                'keterangan' => $keterangan,
                'status' => $request->status ?? 'sedang disiapkan',
            ]);
        }

        // Hitung total harga layanan terkait konsultasi
        $konsultasi = Konsultasi::with('layanan')->find($id_konsultasi);
        $totalHargaLayanan = $konsultasi->layanan->sum('harga');

        $totalHarga = $totalHargaObat + $totalHargaLayanan;

        // Update atau buat transaksi
        Transaksi::updateOrCreate(
            ['id_konsultasi' => $id_konsultasi],
            ['total_harga' => $totalHarga, 'status_pembayaran' => 'belum dibayar']
        );

        $konsultasi->update(['status' => 'Pembayaran']);

        // Kirim notifikasi ke kasir dan pemilik
        $apiToken = 'API-TOKEN-3Kf4h51x2zIfh2Si2fd8LMorPfs5T9JXKiqYv1dnaT1hvwMWXs8crl';
        $gateway = '6288229193849';

        // Ambil data kasir
        $kasir = User::where('role', 'kasir')->first();
        $pemilik = $konsultasi->hewan->pemilik;

        if ($kasir) {
            $nomorKasir = $kasir->phone;
            $pesanKasir = "📢 *Transaksi Baru* 📢\n\n"
                . "👨‍⚕️ Konsultasi ID: {$konsultasi->id_konsultasi}\n"
                . "🐾 Hewan: {$konsultasi->hewan->nama_hewan}\n"
                . "💰 Total Biaya: Rp" . number_format($totalHarga, 0, ',', '.') . "\n"
                . "🔄 Status: Menunggu Pembayaran\n\n"
                . "Silakan siapkan proses pembayaran.";

            Http::withToken($apiToken)->post('http://app.japati.id/api/send-message', [
                'gateway' => $gateway,
                'number' => $nomorKasir,
                'type' => 'text',
                'message' => $pesanKasir,
            ]);
        }

        if ($pemilik) {
            $nomorPemilik = $pemilik->user->phone;
            $pesanPemilik = "📢 *Tagihan Konsultasi* 📢\n\n"
                . "Halo {$pemilik->user->name}, berikut rincian tagihan konsultasi Anda:\n\n"
                . "🐶 Hewan: {$konsultasi->hewan->nama_hewan}\n"
                . "💰 Total Biaya: Rp" . number_format($totalHarga, 0, ',', '.') . "\n"
                . "🔄 Status: Menunggu Pembayaran\n\n"
                . "Silakan menuju kasir untuk menyelesaikan pembayaran. Terima kasih telah mempercayakan layanan kami!";

            Http::withToken($apiToken)->post('http://app.japati.id/api/send-message', [
                'gateway' => $gateway,
                'number' => $nomorPemilik,
                'type' => 'text',
                'message' => $pesanPemilik,
            ]);
        }

        return redirect()->route('apoteker.resep_obat.index')->with('success', 'Resep Obat dan Transaksi berhasil diperbarui.');
    }



    public function destroy(ResepObat $resepObat)
    {
        $resepObat->delete();
        return redirect()->route('apoteker.resep_obat.index')->with('success', 'Resep Obat berhasil dihapus.');
    }

    public function show($id_konsultasi)
    {
        // Ambil resep obat berdasarkan id_konsultasi
        $resepGroup = ResepObat::with('obat', 'konsultasi')->where('id_konsultasi', $id_konsultasi)->get();

        // Pastikan resep ditemukan
        if ($resepGroup->isEmpty()) {
            return redirect()->route('pemilik-hewan.resep_obat.index')->with('error', 'Resep obat tidak ditemukan.');
        }

        // Tampilkan rincian resep obat
        return view('pemilik-hewan.resep_obat.show', compact('resepGroup', 'id_konsultasi'));
    }
}
