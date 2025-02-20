<?php

namespace App\Http\Controllers;

use App\Models\pemilik_hewan;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PemilikHewanController extends Controller
{
    public function index()
    {
        // Cek role pengguna yang sedang login
        if (auth()->user()->role == 'pemilik_hewan') {
            // Ambil data pemilik hewan terkait dengan user yang login
            $userId = auth()->user()->id;

            // Ambil data pemilik hewan berdasarkan user_id
            $data = pemilik_hewan::with('user')
                ->where('id_user', $userId)
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
    $validated = $request->validate([
        'nama' => 'required|string|max:50',
        'phone' => 'required|string|max:13|exists:users,phone',
        'jenkel' => 'required|in:pria,wanita',
        'alamat' => 'nullable|string',
    ]);

    // Ensure the authenticated user has the right id_user
    $userId = Auth::id(); // Get the authenticated user ID

    // Create a new pemilik_hewan profile
    pemilik_hewan::create([
        'id_user' => $userId,   // Store the authenticated user's ID
        'nama' => $validated['nama'],
        'jenkel' => $validated['jenkel'],
        'alamat' => $validated['alamat'],
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
    $pemilik = pemilik_hewan::findOrFail($id_pemilik);

    if (auth()->user()->role === 'pemilik_hewan' && auth()->id() !== $pemilik->id_user) {
        abort(403, 'Unauthorized action.');
    }

    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'phone' => 'required|string|max:13|unique:users,phone,' . $pemilik->id_user . ',id',
        'jenkel' => 'required|in:pria,wanita',
        'alamat' => 'nullable|string',
    ]);

    $pemilik->update([
        'nama' => $validated['nama'],
        'jenkel' => $validated['jenkel'],
        'alamat' => $validated['alamat'],
    ]);

    $redirectRoute = auth()->user()->role === 'pemilik_hewan' 
        ? 'pemilik-hewan.pemilik_hewan.index' 
        : 'admin.pemilik_hewan.index';

    return redirect()->route($redirectRoute)->with('success', 'Data berhasil diupdate.');
}

    // Menghapus data pemilik hewan
    public function destroy($id_pemilik)
    {
        // Menemukan pemilik hewan yang akan dihapus
        $pemilikHewan = pemilik_hewan::findOrFail($id_pemilik);
        $pemilikHewan->delete();

        return redirect()->route('admin.pemilik_hewan.index')->with('success', 'Pemilik Hewan berhasil dihapus.');
    }
    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);
    
        $pemilik = pemilik_hewan::findOrFail($id); // Pastikan model sesuai
        $pemilik->user->update([
            'password' => Hash::make($request->password),
        ]);
    
        return redirect()->back()->with('success', 'Password berhasil diperbarui.');
    }
    
}