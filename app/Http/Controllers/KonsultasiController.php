<?php

namespace App\Http\Controllers;

use App\Models\konsultasi;
use App\Models\Dokter;
use App\Models\hewan;
use App\Models\pemilik_hewan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KonsultasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = now()->toDateString();  // Dapatkan tanggal hari ini
        $konsultasi = Konsultasi::with(['dokter', 'hewan'])
            ->whereDate('tanggal_konsultasi', $today)  // Filter hanya untuk tanggal konsultasi hari ini
            ->where('status', 'Menunggu')  // Filter hanya untuk status "Menunggu"
            ->get();

        if (auth()->user()->role == 'pemilik_hewan') {
            return view('pemilik-hewan.konsultasi.index', compact('konsultasi'));
        }

        return view('kasir.daftar_ulang.index', compact('konsultasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dokter = Dokter::all();
        $hewan = Hewan::all();
        return view('kasir.daftar_ulang.create', compact('dokter', 'hewan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:tbl_dokter,id',
            'id_hewan' => 'required|exists:hewan,id_hewan',
            'keluhan' => 'required|string',
            'tanggal_konsultasi' => 'required|date',
            'status' => 'required|in:Menunggu,Sedang Perawatan,Pembuatan Obat,Selesai,Diterima,Dibatalkan',
        ]);

        // Hitung nomor antrian untuk tanggal konsultasi
        $today = now()->toDateString();  // Dapatkan tanggal saat ini (atau bisa berdasarkan tanggal yang dipilih)
        $lastQueueNumber = Konsultasi::whereDate('tanggal_konsultasi', $request->tanggal_konsultasi)
            ->where('status', 'Menunggu')  // Hanya hitung yang statusnya "Menunggu"
            ->max('no_antrian');  // Ambil nomor antrian terbesar pada hari tersebut

        // Tentukan nomor antrian berikutnya
        $nextQueueNumber = $lastQueueNumber ? intval(substr($lastQueueNumber, 3)) + 1 : 1; // Ambil nomor antrian terakhir dan tambah 1
        $formattedQueueNumber = 'ATR' . str_pad($nextQueueNumber, 4, '0', STR_PAD_LEFT);  // Format dengan 4 digit

        // Simpan data konsultasi dengan nomor antrian
        $requestData = $request->all();
        $requestData['no_antrian'] = $formattedQueueNumber;

        Konsultasi::create($requestData);


        return redirect()->route('kasir.konsultasi.index')->with('success', 'Konsultasi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Konsultasi $konsultasi)
    {
        $dokter = Dokter::all();
        $hewan = Hewan::all();
        return view('kasir.daftar_ulang.edit', compact('konsultasi', 'dokter', 'hewan'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Konsultasi $konsultasi)
    {
        $request->validate([
            'dokter_id' => 'required|exists:tbl_dokter,id',
            'id_hewan' => 'required|exists:hewan,id_hewan',
            'keluhan' => 'required|string',
            'tanggal_konsultasi' => 'required|date',
            'status' => 'required|in:Menunggu,Sedang Perawatan,Pembuatan Obat,Selesai,Diterima,Dibatalkan',
        ]);

        // Tentukan nomor antrean berikutnya
        $tanggal_konsultasi = $request->tanggal_konsultasi;
        $lastQueueNumber = Konsultasi::whereDate('tanggal_konsultasi', $tanggal_konsultasi)
            ->max('no_antrian');

        $nextQueueNumber = $lastQueueNumber ? intval(substr($lastQueueNumber, 3)) + 1 : 1;
        $formattedQueueNumber = 'ATR' . str_pad($nextQueueNumber, 4, '0', STR_PAD_LEFT);

        // Persiapkan data untuk update
        $requestData = $request->all();
        $requestData['no_antrian'] = $formattedQueueNumber;

        // Update data konsultasi
        $konsultasi->update($requestData);

        // Setelah update, tambahkan data ke tabel antrian
        // Cek apakah sudah ada antrian yang berhubungan dengan konsultasi
        $antrian = $konsultasi->antrian()->first();

        if (!$antrian) {
            // Jika belum ada antrian, buat data antrian baru
            $konsultasi->antrian()->create([
                'no_antrian' => $formattedQueueNumber,
                'status' => 'Menunggu', // Status awal adalah Menunggu
            ]);
        }

        // **Mengirim Pesan ke Pemilik Hewan**
        $hewan = Hewan::find($request->id_hewan);
        $pemilik = pemilik_hewan::where('id_pemilik', $hewan->id_pemilik)->first();

        $apiToken = 'API-TOKEN-3Kf4h51x2zIfh2Si2fd8LMorPfs5T9JXKiqYv1dnaT1hvwMWXs8crl';
        $gateway = '6288229193849';

        if ($pemilik) {
            $nomorPemilik = $pemilik->user->phone;
            $pesanPemilik = "📢 *Pembaruan Konsultasi* 📢\n\n"
                . "🐶 Hewan: {$hewan->nama_hewan}\n"
                . "📅 Tanggal Konsultasi: {$konsultasi->tanggal_konsultasi}\n"
                . "🔄 Status: {$konsultasi->status}\n"
                . "📌 No. Antrian: {$formattedQueueNumber}\n\n"
                . "Silahkan tunggu Nomor Antrian Anda dipanggil.\n"
                . "Terima kasih telah mempercayakan layanan kami!";

            Http::withToken($apiToken)->post('http://app.japati.id/api/send-message', [
                'gateway' => $gateway,
                'number' => $nomorPemilik,
                'type' => 'text',
                'message' => $pesanPemilik,
            ]);
        }

        // **Mengirim Pesan ke Dokter**
        $dokter = Dokter::find($request->dokter_id);
        if ($dokter) {
            $nomorDokter = $dokter->user->phone; // Asumsikan nomor dokter ada di tabel users
            $pesanDokter = "🔔 *Notifikasi Konsultasi Baru* 🔔\n\n"
                . "👨‍⚕️ Dokter: {$dokter->user->nama}\n"
                . "🐾 Hewan: {$hewan->nama_hewan}\n"
                . "📅 Tanggal Konsultasi: {$konsultasi->tanggal_konsultasi}\n"
                . "📝 Keluhan: {$request->keluhan}\n"
                . "📌 No. Antrian: {$formattedQueueNumber}\n\n"
                . "Silakan bersiap untuk pemeriksaan.";

            Http::withToken($apiToken)->post('http://app.japati.id/api/send-message', [
                'gateway' => $gateway,
                'number' => $nomorDokter,
                'type' => 'text',
                'message' => $pesanDokter,
            ]);
        }

        return redirect()->route('kasir.konsultasi.index')->with('success', 'Daftar Ulang Telah Berhasil.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Konsultasi $konsultasi)
    {
        $konsultasi->delete();

        return redirect()->route('kasir.konsultasi.index')->with('success', 'Konsultasi berhasil dihapus.');
    }
}
