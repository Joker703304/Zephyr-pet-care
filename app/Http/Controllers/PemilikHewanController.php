<?php

namespace App\Http\Controllers;

use App\Models\pemilik_hewan;
use App\Models\user;
use Illuminate\Http\Request;

class PemilikHewanController extends Controller
{
    public function index()
{
    // Cek role pengguna yang sedang login
    if (auth()->user()->role == 'pemilik_hewan') {
        // Ambil data pemilik hewan terkait dengan user yang login
        $userId = auth()->user()->email;

        // Ambil data pemilik hewan berdasarkan user_id
        $data = pemilik_hewan::with('user')
            ->where('email', $userId)
            ->get();

        // Tampilkan view untuk pemilik hewan
        return view('pemilik-hewan.pemilik_hewan.index', compact('data'));
    }

    // Jika role adalah admin, ambil semua data pemilik hewan
    $data = pemilik_hewan::with('user')->get();

    // Tampilkan view untuk admin
    return view('admin.pemilik_hewan.index', compact('data'));
}


    // Menampilkan form untuk menambah pemilik hewan baru
    public function create()
    {
        // Ambil semua email dari tabel users yang memiliki role 'pemilik_hewan'
        $user = auth()->user();
        $emails = User::where('role', 'pemilik_hewan')->pluck('email', 'email'); // Hanya email dengan role pemilik_hewan
        return view('pemilik-hewan.pemilik_hewan.create', compact('emails', 'user'));
    }

    // Menyimpan data pemilik hewan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|exists:users,email', // Validasi email harus ada di tabel users dengan role pemilik_hewan
            'jenkel' => 'required|in:pria,wanita',
            'alamat' => 'required|string|max:255',
            'no_tlp' => 'required|string|max:15',
        ]);

        // Periksa apakah email sudah ada di tabel pemilik_hewan
        if (pemilik_hewan::where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'Email ini sudah terdaftar pada pemilik hewan.'])->withInput();
        }

        // Simpan data ke tabel pemilik_hewan
        pemilik_hewan::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'jenkel' => $request->jenkel,
            'alamat' => $request->alamat,
            'no_tlp' => $request->no_tlp,
        ]);

        return redirect()->route('pemilik-hewan.dashboard')->with('success', 'Data pemilik hewan berhasil disimpan.');
    }

    // Menampilkan form untuk mengedit data pemilik hewan
    public function edit($id_pemilik)
    {
        $pemilik = pemilik_hewan::findOrFail($id_pemilik);
        if (!in_array(auth()->user()->role, ['admin', 'pemilik_hewan'])) {
            abort(403, 'Unauthorized action.');
        }

        if (auth()->user()->role === 'pemilik_hewan') {
            return view('pemilik-hewan.pemilik_hewan.edit', compact('pemilik'));
        }
        return view('admin.pemilik_hewan.edit', compact('pemilik'));
    }

    // Memperbarui data pemilik hewan yang sudah ada
    public function update(Request $request, $id_pemilik)
    {
        // Menemukan pemilik hewan yang akan diperbarui
        $pemilik = pemilik_hewan::findOrFail($id_pemilik);

        if (!in_array(auth()->user()->role, ['admin', 'pemilik_hewan'])) {
            abort(403, 'Unauthorized action.');
        }
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

        $redirectRoute = auth()->user()->role === 'pemilik_hewan' ? 'pemilik-hewan.pemilik_hewan.index' : 'admin.pemilik_hewan.index';
        return redirect()->route($redirectRoute)->with('success', 'Hewan berhasil diupdate.');
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
