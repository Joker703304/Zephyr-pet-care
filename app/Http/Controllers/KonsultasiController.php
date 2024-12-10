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
        $konsultasi = Konsultasi::with(['dokter', 'hewan'])->get();
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

        Konsultasi::create($request->all());

        return redirect()->route('admin.konsultasi.index')->with('success', 'Konsultasi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Konsultasi $konsultasi)
    {
        $dokter = Dokter::all();
        $hewan = Hewan::all();
        return view('admin.konsultasi.edit', compact('konsultasi', 'dokter', 'hewan'));
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
            'status' => 'required|in:Menunggu,Sedang Diproses,Selesai,Dibatalkan',
        ]);

        $konsultasi->update($request->all());

        return redirect()->route('admin.konsultasi.index')->with('success', 'Konsultasi berhasil diperbarui.');
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
