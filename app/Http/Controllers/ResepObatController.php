<?php

namespace App\Http\Controllers;

use App\Models\ResepObat;
use App\Models\konsultasi;
use App\Models\obat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResepObatController extends Controller
{
    public function index()
    {
        $resep_obat = ResepObat::with(['konsultasi', 'obat'])->get();
        return view('apoteker.resep_obat.index', compact('resep_obat'));
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
            'id_obat' => 'required|exists:obat,id_obat',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        ResepObat::create($request->all());
        return redirect()->route('apoteker.resep_obat.index')->with('success', 'Resep Obat berhasil ditambahkan.');
    }

    public function edit(ResepObat $resepObat)
    {
        $konsultasi = konsultasi::all();
        $obat = obat::all();
        return view('apoteker.resep_obat.edit', compact('resepObat', 'konsultasi', 'obat'));
    }

    public function update(Request $request, ResepObat $resepObat)
    {
        $request->validate([
            'id_konsultasi' => 'required|exists:konsultasi,id_konsultasi',
            'id_obat' => 'required|exists:obat,id_obat',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $resepObat->update($request->all());
        return redirect()->route('apoteker.resep_obat.index')->with('success', 'Resep Obat berhasil diperbarui.');
    }

    public function destroy(ResepObat $resepObat)
    {
        $resepObat->delete();
        return redirect()->route('apoteker.resep_obat.index')->with('success', 'Resep Obat berhasil dihapus.');
    }
}

