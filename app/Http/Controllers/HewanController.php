<?php

namespace App\Http\Controllers;

use App\Models\Hewan;
use App\Models\pemilik_hewan;
use App\Models\JenisHewan;
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
    
    // Menampilkan form tambah jenis hewan
    public function createJenis()
    {
        return view('admin.hewan.create-jenis');
    }

    // Menyimpan jenis hewan baru
    public function storeJenis(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255|unique:jenis_hewan,nama_jenis',
        ]);
    
        JenisHewan::create(['nama_jenis' => $request->nama_jenis]);
        // Redirect ke halaman daftar jenis hewan setelah berhasil menyimpan
        return redirect()->route('admin.hewan.show-jenis')->with('success', 'Jenis Hewan berhasil ditambahkan!');
    }

    // Menampilkan daftar jenis hewan yang unik
    public function showJenis()
{
    // Mengambil data jenis hewan dari tabel jenis_hewan
    $jenisHewan = JenisHewan::select('nama_jenis')->distinct()->get();

    // Melanjutkan untuk menampilkan view
    return view('admin.hewan.show-jenis', compact('jenisHewan'));
}

    public function create()
{
    // Ambil jenis hewan yang sudah ada di tabel hewan
    $jenisHewan = JenisHewan::all();

    if (auth()->user()->role === 'pemilik_hewan') {
        $pemilikId = auth()->user()->pemilikhewan->id_pemilik;

        // Pass pemilikId dan jenisHewan ke view untuk pemilik_hewan
        return view('pemilik-hewan.hewan.create', compact('pemilikId', 'jenisHewan'));
    }

    // Pass jenisHewan ke view untuk admin
    return view('admin.hewan.create', compact('jenisHewan'));
}

public function store(Request $request)
{
    if (!in_array(auth()->user()->role, ['admin', 'pemilik_hewan'])) {
        abort(403, 'Unauthorized action.');
    }

    // Validasi input
    $request->validate([
        'id_pemilik' => 'required|exists:pemilik_hewan,id_pemilik',
        'nama_hewan' => 'required|string|max:255',
        'jenis_id' => 'required|exists:jenis_hewan,id', // Pastikan validasi menggunakan jenis_id
        'jenkel' => 'required|in:jantan,betina',
        'umur' => 'nullable|integer',
        'berat' => 'nullable|string',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Menyimpan foto jika ada
    $fotoPath = $request->file('foto') ? $request->file('foto')->store('uploads/hewan', 'public') : null;

    // Simpan data ke tabel Hewan, menggunakan jenis_id
    Hewan::create([
        'id_pemilik' => $request->id_pemilik,
        'nama_hewan' => $request->nama_hewan,
        'jenis_id' => $request->jenis_id, // Menyimpan jenis_id
        'jenkel' => $request->jenkel,
        'umur' => $request->umur,
        'berat' => $request->berat,
        'foto' => $fotoPath,
    ]);

    // Redirect sesuai dengan role user
    $redirectRoute = auth()->user()->role === 'pemilik_hewan' ? 'pemilik-hewan.hewan.index' : 'admin.hewan.index';
    return redirect()->route($redirectRoute)->with('success', 'Hewan berhasil ditambahkan.');
}
    
public function edit($id)
{
    // Ambil data hewan berdasarkan id
    $hewan = Hewan::findOrFail($id);

    // Ambil semua jenis hewan yang ada di tabel jenis_hewan
    $jenisHewan = JenisHewan::all();

    // Kirim data hewan dan jenis hewan ke view
    return view('pemilik-hewan.hewan.edit', compact('hewan', 'jenisHewan'));
}

public function update(Request $request, Hewan $hewan)
{
    if (!in_array(auth()->user()->role, ['admin', 'pemilik_hewan'])) {
        abort(403, 'Unauthorized action.');
    }

    // Validasi input data
    $request->validate([
        'nama_hewan' => 'required|string|max:255',
        'jenis_id' => 'required|exists:jenis_hewan,id',  // Pastikan jenis_id valid
        'jenkel' => 'required|in:jantan,betina',
        'umur' => 'nullable|integer',
        'berat' => 'nullable|numeric',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Menangani foto, jika ada file foto yang diunggah
    if ($request->hasFile('foto')) {
        // Hapus foto lama jika ada
        if ($hewan->foto) {
            Storage::disk('public')->delete($hewan->foto);
        }
        // Simpan foto baru
        $fotoPath = $request->file('foto')->store('uploads/hewan', 'public');
    } else {
        // Jika tidak ada foto baru, gunakan foto yang lama
        $fotoPath = $hewan->foto;
    }

    // Update data hewan dengan data baru
    $hewan->update([
        'nama_hewan' => $request->nama_hewan,
        'jenis_id' => $request->jenis_id,  // Pastikan menggunakan jenis_id yang dipilih
        'jenkel' => $request->jenkel,
        'umur' => $request->umur,
        'berat' => $request->berat,
        'foto' => $fotoPath,  // Update foto jika ada
    ]);

    // Tentukan halaman redirect berdasarkan role
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
