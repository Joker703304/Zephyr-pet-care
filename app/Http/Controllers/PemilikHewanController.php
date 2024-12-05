<?php

namespace App\Http\Controllers;

use App\Models\pemilik_hewan;
use App\Models\user;
use Illuminate\Http\Request;

class PemilikHewanController extends Controller
{
    public function index()
    {
        $data = pemilik_hewan::with('user')->get(); // Memuat relasi 'user'
        return view('admin.pemilik_hewan.index', compact('data'));
    }

    // Menampilkan form untuk menambah pemilik hewan baru
    // public function create()
    // {
    //     // Ambil semua email dari tabel users
    //     $emails = User::pluck('email', 'email'); // Mengambil email sebagai value dan label
    //     return view('admin.pemilik_hewan.create', compact('emails'));
    // }      

    // // Menyimpan data pemilik hewan baru
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nama' => 'required|string|max:255',
    //         'email' => 'required|email|exists:users,email', // Validasi email harus ada di tabel users
    //         'jenkel' => 'required|in:pria,wanita',
    //         'alamat' => 'required|string|max:255',
    //         'no_tlp' => 'required|string|max:15',
    //     ]);

    //     // Periksa apakah email sudah ada di tabel pemilik_hewan
    //     if (pemilik_hewan::where('email', $request->email)->exists()) {
    //         return back()->withErrors(['email' => 'Email ini sudah terdaftar pada pemilik hewan.'])->withInput();
    //     }

    //     // Simpan data ke tabel pemilik_hewan
    //     pemilik_hewan::create([
    //         'nama' => $request->nama,
    //         'email' => $request->email,
    //         'jenkel' => $request->jenkel,
    //         'alamat' => $request->alamat,
    //         'no_tlp' => $request->no_tlp,
    //     ]);

    //     return redirect()->route('admin.pemilik_hewan')->with('success', 'Data pemilik hewan berhasil disimpan.');
    // }

    // Menampilkan form untuk mengedit data pemilik hewan
    public function edit($id_pemilik)
    {
        $pemilik = pemilik_hewan::findOrFail($id_pemilik);
        return view('admin.pemilik_hewan.edit', compact('pemilik'));
    }

    // Memperbarui data pemilik hewan yang sudah ada
    public function update(Request $request, $id_pemilik)
    {
        // Menemukan pemilik hewan yang akan diperbarui
        $pemilik = pemilik_hewan::findOrFail($id_pemilik);

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $pemilik->user->id, // Validasi unik, kecuali untuk email yang sama
            'jenkel' => 'required',
            'alamat' => 'required|string',
            'no_tlp' => 'required|string|max:15',
        ]);

        // Menemukan pemilik hewan yang akan diperbarui
        $pemilikHewan = pemilik_hewan::findOrFail($id_pemilik);
        
        // Update field yang diperbarui
        $pemilikHewan->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'jenkel' => $request->jenkel,
            'alamat' => $request->alamat,
            'no_tlp' => $request->no_tlp,
        ]);

        return redirect()->route('admin.pemilik_hewan.index')->with('success', 'Pemilik Hewan berhasil diperbarui.');
    }

    // Menghapus data pemilik hewan
    public function destroy($id_pemilik)
    {
        // Menemukan pemilik hewan yang akan dihapus
        $pemilikHewan = pemilik_hewan::findOrFail($id_pemilik);
        $pemilikHewan->delete();

        return redirect()->route('admin.pemilik_hewan.index')->with('success', 'Pemilik Hewan berhasil dihapus.');
    }
}
