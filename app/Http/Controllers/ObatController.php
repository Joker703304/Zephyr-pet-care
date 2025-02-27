<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\obat;

class ObatController extends Controller
{
    public function index()
    {
        $obats = obat::all();

        if (auth()->user()->role == 'apoteker') {
            return view('apoteker.obat.index', compact('obats'));
        }

        return view('admin.obat.index', compact('obats'));
    }

    // Menampilkan form untuk menambahkan obat baru
    public function create()
    {
        if (auth()->user()->role === 'apoteker') {
            return view('apoteker.obat.create');
        }

        return view('admin.obat.create');
    }

    // Menyimpan obat baru ke database
    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin', 'apoteker'])) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'nama_obat' => 'required|string',
            'jenis_obat' => 'nullable|string',
            'stok' => 'required|integer',
            'harga' => 'required|string',
        ]);

        $lastObat = obat::latest()->first();

        // Mengambil angka terakhir dan menambahkannya satu
        $lastId = $lastObat ? (int) substr($lastObat->id_obat, 1) : 0;
        $newId = 'D' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);

        while (obat::where('id_obat', $newId)->exists()) {
            $lastId++;
            $newId = 'D' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);
        }

        obat::create([
            'id_obat' => $newId,
            'nama_obat' => $request->nama_obat,
            'jenis_obat' => $request->jenis_obat,
            'stok' => $request->stok,
            'harga' => $request->harga,
        ]);

        $redirectRoute = auth()->user()->role === 'apoteker' ? 'apoteker.obat.index' : 'admin.obat.index';
        return redirect()->route($redirectRoute)->with('success', 'Obat berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit data obat
    public function edit(obat $obat)
    {
        if (!in_array(auth()->user()->role, ['admin', 'apoteker'])) {
            abort(403, 'Unauthorized action.');
        }

        if (auth()->user()->role === 'apoteker') {
            return view('apoteker.obat.edit', compact('obat'));
        }

        return view('admin.obat.edit', compact('obat'));
    }

    // Memperbarui data obat di database
    public function update(Request $request, obat $obat)
    {
        if (!in_array(auth()->user()->role, ['admin', 'apoteker'])) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'nama_obat' => 'required|string',
            'jenis_obat' => 'nullable|string',
            'stok' => 'required|integer',
            'harga' => 'required|string',
        ]);

        $obat->update($request->all());

        $redirectRoute = auth()->user()->role === 'apoteker' ? 'apoteker.obat.index' : 'admin.obat.index';
        return redirect()->route($redirectRoute)->with('success', 'Obat berhasil diperbarui.');
    }

    // Menghapus data obat
    public function destroy(obat $obat)
    {
        if (!in_array(auth()->user()->role, ['admin', 'apoteker'])) {
            abort(403, 'Unauthorized action.');
        }

        $obat->delete();

        $redirectRoute = auth()->user()->role === 'apoteker' ? 'apoteker.obat.index' : 'admin.obat.index';
        return redirect()->route($redirectRoute)->with('success', 'Obat berhasil dihapus.');
    }
}