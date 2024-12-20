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
        // Mendapatkan user yang sedang login
        $user = auth()->user();

        // Jika role user adalah pemilik_hewan, filter berdasarkan nama pemilik
        if ($user->role == 'pemilik_hewan') {
            // Mengambil data hewan yang dimiliki oleh pemilik yang sedang login berdasarkan nama pemilik
            $hewan = Hewan::with('pemilik')
                        ->whereHas('pemilik', function ($query) use ($user) {
                            $query->where('email', $user->email); // Menyaring berdasarkan nama pemilik yang login
                        })
                        ->get();
        } else {
            // Jika role user bukan pemilik_hewan (misalnya admin), tampilkan semua hewan
            $hewan = Hewan::with('pemilik')->get();
        }

        // Menampilkan view sesuai dengan role user
        if ($user->role == 'pemilik_hewan') {
            return view('pemilik-hewan.hewan.index', compact('hewan'));
        }
        
        return view('admin.hewan.index', compact('hewan'));
    }

    public function create()
    {
        $pemilik = pemilik_hewan::all();

        if (auth()->user()->role === 'pemilik_hewan') {
            return view('pemilik-hewan.hewan.create', compact('pemilik'));
        }

        return view('admin.hewan.create', compact('pemilik'));
    }

    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin', 'pemilik_hewan'])) {
            abort(403, 'Unauthorized action.');
        }

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

        $redirectRoute = auth()->user()->role === 'pemilik_hewan' ? 'pemilik-hewan.hewan.index' : 'admin.hewan.index';
        return redirect()->route($redirectRoute)->with('success', 'Hewan berhasil ditambahkan.');
    }

    public function edit(Hewan $hewan)
    {
        $pemilik = pemilik_hewan::all();
        if (!in_array(auth()->user()->role, ['admin', 'pemilik_hewan'])) {
            abort(403, 'Unauthorized action.');
        }

        if (auth()->user()->role === 'pemilik_hewan') {
            return view('pemilik-hewan.hewan.edit', compact('hewan', 'pemilik'));
        }
        return view('admin.hewan.edit', compact('hewan', 'pemilik'));
    }

    public function update(Request $request, Hewan $hewan)
    {
        if (!in_array(auth()->user()->role, ['admin', 'pemilik_hewan'])) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            // 'id_pemilik' => 'required|exists:pemilik_hewan,id_pemilik',
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

        $redirectRoute = auth()->user()->role === 'pemilik_hewan' ? 'pemilik-hewan.hewan.index' : 'admin.hewan.index';
        return redirect()->route($redirectRoute)->with('success', 'Hewan berhasil diupdate.');
    }

    public function destroy(Hewan $hewan)
    {
        if ($hewan->foto) {
            Storage::disk('public')->delete($hewan->foto);
        }
        $hewan->delete();

        $redirectRoute = auth()->user()->role === 'pemilik_hewan' ? 'pemilik-hewan.hewan.index' : 'admin.hewan.index';
        return redirect()->route($redirectRoute)->with('success', 'Hewan berhasil dihapus.');
    }
}
