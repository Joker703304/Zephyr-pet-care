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
            // Mengambil data hewan yang dimiliki oleh pemilik yang sedang login berdasarkan email
            $hewan = Hewan::with('pemilik')
                        ->whereHas('pemilik', function ($query) use ($user) {
                            $query->where('email', $user->email); // Menyaring berdasarkan email pemilik yang login
                        })
                        // Menyaring hewan yang lengkap (nama_hewan, jenis, jenkel, umur, berat, dan foto tidak boleh null)
                        ->whereNotNull('nama_hewan')
                        ->whereNotNull('jenis')
                        ->whereNotNull('jenkel')
                        ->whereNotNull('umur')
                        ->whereNotNull('berat')
                        ->whereNotNull('foto')
                        ->get();
        } else {
            // Jika role user bukan pemilik_hewan (misalnya admin), tampilkan semua hewan yang lengkap
            $hewan = Hewan::with('pemilik')
                        ->whereNotNull('nama_hewan')
                        ->whereNotNull('jenis')
                        ->whereNotNull('jenkel')
                        ->whereNotNull('umur')
                        ->whereNotNull('berat')
                        ->whereNotNull('foto')
                        ->get();
        }
    
        // Menampilkan view sesuai dengan role user
        if ($user->role == 'pemilik_hewan') {
            return view('pemilik-hewan.hewan.index', compact('hewan'));
        }
    
        return view('admin.hewan.index', compact('hewan'));
    }
    
    // Menampilkan form tambah jenis hewan
    public function createJenis()
    {
        return view('admin.hewan.create-jenis');
    }

    // Menyimpan jenis hewan baru
    public function storeJenis(Request $request)
    {
        // Validasi input
        $request->validate([
            'jenis' => 'required|string|max:255',
        ]);

        // Menyimpan jenis hewan ke dalam database
        Hewan::create([
            'jenis' => $request->jenis,
            'nama_hewan' => 'Nama Hewan Default',  // Nama hewan default
        ]);

        // Redirect ke halaman daftar jenis hewan setelah berhasil menyimpan
        return redirect()->route('admin.hewan.show-jenis')->with('success', 'Jenis Hewan berhasil ditambahkan!');
    }

    // Menampilkan daftar jenis hewan yang unik
    public function showJenis()
    {
        $jenisHewan = Hewan::select('jenis')->distinct()->get();
        return view('admin.hewan.show-jenis', compact('jenisHewan'));
    }

    public function create()
    {
        $pemilik = pemilik_hewan::all();
        $jenisHewan = Hewan::select('jenis')->distinct()->get(); // Ambil semua jenis hewan yang ada

        if (auth()->user()->role === 'pemilik_hewan') {
            $pemilikId = auth()->user()->pemilikhewan->id_pemilik;

            // Pass pemilikId dan jenisHewan ke view untuk pemilik_hewan
            return view('pemilik-hewan.hewan.create', compact('pemilikId', 'jenisHewan'));
        }

        // Pass pemilik dan jenisHewan ke view untuk admin
        return view('admin.hewan.create', compact('pemilik', 'jenisHewan'));
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

    public function edit($id)
    {
        $hewan = Hewan::findOrFail($id);
        $jenisHewan = Hewan::select('jenis')->distinct()->get(); // Ambil semua jenis hewan yang ada

        return view('pemilik-hewan.hewan.edit', compact('hewan', 'jenisHewan'));
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
