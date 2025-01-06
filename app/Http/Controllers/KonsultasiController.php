<?php

namespace App\Http\Controllers;

use App\Models\konsultasi;
use App\Models\Dokter;
use App\Models\hewan;
use Illuminate\Http\Request;

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
        ->get();

    if (auth()->user()->role == 'pemilik_hewan') {
        return view('pemilik-hewan.konsultasi.index', compact('konsultasi'));
    }

    return view('admin.konsultasi.index', compact('konsultasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dokter = Dokter::all();
        $hewan = Hewan::all();
        return view('admin.konsultasi.create', compact('dokter', 'hewan'));
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
            'status' => 'required|in:Menunggu,Sedang Diproses,Selesai,Dibatalkan',
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


        return redirect()->route('admin.konsultasi.index')->with('success', 'Konsultasi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Konsultasi $konsultasi)
{
        $dokter = Dokter::all();
    $hewan = Hewan::all();
    return view('kasir.konsultasi.edit', compact('konsultasi', 'dokter', 'hewan'));
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
            'status' => 'required|in:Menunggu,Sedang Perawatan,Sedang Diproses,Selesai,Dibatalkan',
        ]);

        $dokter = Dokter::findOrFail($request->dokter_id);
    $dokter->update(['status' => 'Sedang Melakukan Perawatan']);


        // Hitung nomor antrian untuk tanggal konsultasi
        $today = now()->toDateString();  // Dapatkan tanggal saat ini (atau bisa berdasarkan tanggal yang dipilih)
        $lastQueueNumber = Konsultasi::whereDate('tanggal_konsultasi', $request->tanggal_konsultasi)
            ->where('status', 'Menunggu')  // Hanya hitung yang statusnya "Menunggu"
            ->max('no_antrian');  // Ambil nomor antrian terbesar pada hari tersebut

        // Tentukan nomor antrian berikutnya
        $nextQueueNumber = $lastQueueNumber ? intval(substr($lastQueueNumber, 3)) + 1 : 1; // Ambil nomor antrian terakhir dan tambah 1
        $formattedQueueNumber = 'ATR' . str_pad($nextQueueNumber, 4, '0', STR_PAD_LEFT);  // Format dengan 4 digit

        // Persiapkan data untuk update
        $requestData = $request->all();
        $requestData['no_antrian'] = $formattedQueueNumber;  // Masukkan nomor antrian ke dalam request data

        // Update konsultasi dengan data yang sudah diperbarui
        $konsultasi->update($requestData);


        return redirect()->route('kasir.konsultasi.index')->with('success', 'Daftar Ulang Telah Berhasil.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Konsultasi $konsultasi)
    {
        $konsultasi->delete();

        return redirect()->route('admin.konsultasi.index')->with('success', 'Konsultasi berhasil dihapus.');
    }
}
