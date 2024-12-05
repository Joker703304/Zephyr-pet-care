<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::all();
        return view('admin.obat.index', compact('obats'));
    }

    // Menampilkan form untuk menambahkan obat baru
    // public function create()
    // {
    //     return view('admin.obat.create');
    // }

    // // Menyimpan obat baru ke database
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nama_obat' => 'required|string',
    //         'jenis_obat' => 'nullable|string',
    //         'stok' => 'required|integer',
    //         'harga' => 'required|string',
    //     ]);

    //     $lastObat = Obat::latest()->first();

    //     // Mengambil angka terakhir dan menambahkannya satu
    //     $lastId = $lastObat ? (int) substr($lastObat->id_pemilik, 1) : 0;
    //     $newId = 'D' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);

    //     while (Obat::where('id_obat', $newId)->exists()) {
    //         $lastId++;
    //         $newId = 'D' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);
    //     }

    //     Obat::create([
    //         'id_obat' => $newId,
    //         'nama_obat' => $request->nama_obat,
    //         'jenis_obat' => $request->jenis_obat,
    //         'stok' => $request->stok,
    //         'harga' => $request->harga,
    //     ]);

    //     return redirect()->route('admin.obat')->with('success', 'Obat berhasil ditambahkan.');
    // }

    // Menampilkan form untuk mengedit data obat
    public function edit(Obat $obat)
    {
        return view('admin.obat.edit', compact('obat'));
    }

    // Memperbarui data obat di database
    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'nama_obat' => 'required|string',
            'jenis_obat' => 'nullable|string',
            'stok' => 'required|integer',
            'harga' => 'required|string',
        ]);

        $obat->update($request->all());

        return redirect()->route('admin.obat')->with('success', 'Obat berhasil diperbarui.');
    }

    // Menghapus data obat
    public function destroy(Obat $obat)
    {
        $obat->delete();

        return redirect()->route('admin.obat')->with('success', 'Obat berhasil dihapus.');
    }
}
