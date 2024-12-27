<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\hewan;
use App\Models\konsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class KonsultasiPemilikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $konsultasi = Konsultasi::whereHas('hewan', function ($query) {
            $query->where('id_pemilik', auth()->user()->pemilikhewan->id_pemilik);
        })->get();
    
        return view('pemilik-hewan.konsultasi.index', compact('konsultasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mengambil hewan milik pengguna yang sedang login
        $hewan = Hewan::where('id_pemilik', auth()->user()->pemilikhewan->id_pemilik)->get();
        return view('pemilik-hewan.konsultasi.create', compact('hewan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       // Validasi input
       $request->validate([
        'id_hewan' => 'required|exists:hewan,id_hewan',
        'keluhan' => 'required|string',
        'tanggal_konsultasi' => 'required|date',
    ]);

    // Mengecek apakah jumlah pasien pada tanggal yang dipilih sudah melebihi batas
    $jumlah_pasien = Konsultasi::where('tanggal_konsultasi', $request->tanggal_konsultasi)->count();

    if ($jumlah_pasien >= 3) {
        return redirect()->back()->with('error', 'Maaf, kuota pasien pada tanggal ini sudah penuh.');
    }

    // Membuat data konsultasi
    $konsultasi = new Konsultasi();
    $konsultasi->no_antrian = 'ANTRI-' . strtoupper(Str::random(6));  // Generate no antrian
    $konsultasi->id_hewan = $request->id_hewan;
    $konsultasi->keluhan = $request->keluhan;
    $konsultasi->tanggal_konsultasi = $request->tanggal_konsultasi;
    $konsultasi->status = 'Menunggu'; // Status awal
    $konsultasi->save();

    return redirect()->route('pemilik-hewan.konsultasi.index')->with('success', 'Konsultasi berhasil diajukan.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
