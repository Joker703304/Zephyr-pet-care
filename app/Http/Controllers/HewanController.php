<?php

namespace App\Http\Controllers;

use App\Models\Hewan;
use App\Models\pemilik_hewan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HewanController extends Controller
{
    public function index()
    {
        $hewan = Hewan::with('pemilik')->get();
        return view('admin.hewan.index', compact('hewan'));
    }

    public function create()
    {
        $pemilik = pemilik_hewan::all();
        return view('admin.hewan.create', compact('pemilik'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pemilik' => 'required|exists:pemilik_hewan,id_pemilik',
            'nama_hewan' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'jenkel' => 'required|in:jantan,betina',
            'umur' => 'nullable|integer',
            'berat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoPath = $request->file('foto') ? $request->file('foto')->store('uploads/hewan', 'public') : null;

        Hewan::create(array_merge($request->all(), ['foto' => $fotoPath]));

        return redirect()->route('admin.hewan.index')->with('success', 'Hewan berhasil ditambahkan.');
    }

    public function edit(Hewan $hewan)
    {
        $pemilik = pemilik_hewan::all();
        return view('admin.hewan.edit', compact('hewan', 'pemilik'));
    }

    public function update(Request $request, Hewan $hewan)
    {
        $request->validate([
            'id_pemilik' => 'required|exists:pemilik_hewan,id_pemilik',
            'nama_hewan' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'jenkel' => 'required|in:jantan,betina',
            'umur' => 'nullable|integer',
            'berat' => 'nullable|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($hewan->foto) {
                Storage::disk('public')->delete($hewan->foto);
            }
            $fotoPath = $request->file('foto')->store('uploads/hewan', 'public');
        } else {
            $fotoPath = $hewan->foto;
        }

        $hewan->update(array_merge($request->all(), ['foto' => $fotoPath]));

        return redirect()->route('admin.hewan.index')->with('success', 'Hewan berhasil diperbarui.');
    }

    public function destroy(Hewan $hewan)
    {
        if ($hewan->foto) {
            Storage::disk('public')->delete($hewan->foto);
        }
        $hewan->delete();

        return redirect()->route('admin.hewan.index')->with('success', 'Hewan berhasil dihapus.');
    }
}
