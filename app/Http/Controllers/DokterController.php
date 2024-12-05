<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = Dokter::all();
        return view('admin.dokter.index', compact('dokters'));
    }

    public function create()
    {
        return view('admin.dokter.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'spesialis' => 'nullable|string|max:50',
            'no_telepon' => 'required|string|max:20|unique:tbl_dokter,no_telepon',
            'hari' => 'nullable|string|max:20',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i',
        ]);

        Dokter::create($request->all());

        return redirect()->route('admin.dokter.index')->with('success', 'Dokter added successfully.');
    }

    public function edit(Dokter $dokter)
    {
        return view('admin.dokter.edit', compact('dokter'));
    }

    public function update(Request $request, Dokter $dokter)
    {
        
        $request->validate([
            'nama' => 'required|string|max:100',
            'spesialis' => 'nullable|string|max:50',
            'no_telepon' => 'required|string|max:20|unique:tbl_dokter,no_telepon,' . $dokter->id,
            'hari' => 'nullable|string|max:20',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i',
        ]);

        $dokter->update($request->all());

        return redirect()->route('admin.dokter.index')->with('success', 'Dokter updated successfully.');
    }

    public function destroy(Dokter $dokter)
    {
        $dokter->delete();
        return redirect()->route('admin.dokter.index')->with('success', 'Dokter deleted successfully.');
    }
}
