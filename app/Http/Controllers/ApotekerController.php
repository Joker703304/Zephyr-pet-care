<?php

namespace App\Http\Controllers;

use App\Models\Apoteker;
use Illuminate\Http\Request;
use App\Models\obat;
use App\Models\ResepObat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ApotekerController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya pemilik hewan yang dapat mengakses
        $this->middleware('role:apoteker');
    }

    public function index()
{
    // Ambil data apoteker berdasarkan id_user yang sedang login
    $apoteker = Apoteker::where('id_user', Auth::id())->first();

    if (!$apoteker) {
        return redirect()->route('apoteker.createProfile')->with('warning', 'Mohon Isi data diri terlebih dahulu.');
    }

    // Hitung jumlah obat terdaftar
    $medicationsCount = Obat::count();

    // Hitung jumlah resep yang sedang disiapkan berdasarkan id_konsultasi unik
    $prescriptions = ResepObat::where('status', 'sedang di siapkan')
                                ->distinct('id_konsultasi')
                                ->count('id_konsultasi');

    // Ambil data obat untuk grafik stok obat
    $medications = Obat::select('nama_obat', 'stok')->get();
    $medicineNames = $medications->pluck('nama_obat')->toArray();
    $medicineStock = $medications->pluck('stok')->toArray();

    // Hitung kategori resep dan jumlahnya berdasarkan id_konsultasi unik
    $prescriptionData = ResepObat::select('status', DB::raw('COUNT(DISTINCT id_konsultasi) as count'))
                                ->groupBy('status')
                                ->get();
    
    $prescriptionCategories = $prescriptionData->pluck('status')->toArray();
    $prescriptionCounts = $prescriptionData->pluck('count')->toArray();

    return view('apoteker.dashboard', compact(
        'medicationsCount',
        'prescriptions',
        'medicineNames',
        'medicineStock',
        'prescriptionCategories',
        'prescriptionCounts'
    ));
}

    public function profile()
    {
        // Cek role pengguna yang sedang login
        if (auth()->user()->role == 'apoteker') {
            // Ambil data pemilik hewan terkait dengan user yang login
            $userId = auth()->user()->id;

            // Ambil data pemilik hewan berdasarkan user_id
            $data = Apoteker::with('user')
                ->where('id_user', $userId)
                ->get();

            // Tampilkan view untuk pemilik hewan
            return view('apoteker.index', compact('data'));
        }

        // Jika role adalah admin, ambil semua data pemilik hewan
        $data = Apoteker::with('user')->get();

        // Tampilkan view untuk admin
        return view('admin.apoteker.index', compact('data'));
    }

    public function manageObat()
    {
        // Ambil semua pengguna untuk dikelola
        $obats = Obat::all();
        return view('admin.obat', compact('obats'));
    }

    public function manageResepObat()
    {
        // Ambil semua pengguna untuk dikelola
        $resep_obat = ResepObat::all();
        return view('admin.resep_obat', compact('resep_obat'));
    }

    public function createProfile()
    {
        $user = auth()->user();
        return view('apoteker.createProfile', compact('user'));
    }

    public function storeProfile(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'nama' => 'required|string|max:50',
            'phone' => 'required|string|max:13|exists:users,phone',
            'jenkel' => 'required|in:pria,wanita',
            'alamat' => 'nullable|string',
        ]);

        // Create a new doctor profile
        Apoteker::create([
            'id_user' => Auth::id(),
            'nama' => $validated['nama'],
            'jenkel' => $validated['jenkel'],
            'alamat' => $validated['alamat'],
        ]);

        // Redirect to the dashboard after the profile is created
        return redirect()->route('apoteker.dashboard')->with('success', 'Your profile has been created successfully.');
    }

    public function editProfile()
    {
        // Get the doctor's profile
        $apoteker = Apoteker::where('id_user', Auth::id())->first();

        // Return the profile edit view with the doctor's current data
        return view('apoteker.editProfile', compact('apoteker'));
    }

    public function updateProfile(Request $request)
{
    // Temukan apoteker berdasarkan id_user (auth)
    $apoteker = Apoteker::where('id_user', Auth::id())->first();

    // Validasi data yang masuk
    $validated = $request->validate([
        'name' => 'required|string|max:255',  // Validasi untuk nama
        'phone' => 'string|max:13|unique:users,phone,' . $apoteker->id_user . ',id',  // Validasi untuk nomor telepon
        'jenkel' => 'required|in:pria,wanita',  // Validasi untuk jenis kelamin
        'alamat' => 'nullable|string',  // Validasi untuk alamat
    ]);

    // Update nama pengguna dan nomor telepon pada tabel users
    $apoteker->user->update([
        'name' => $validated['name'],
    ]);

    // Update data apoteker
    $apoteker->update([
        'jenkel' => $validated['jenkel'],
        'alamat' => $validated['alamat'],
    ]);

    // Redirect ke halaman profil dengan pesan sukses
    return redirect()->route('apoteker.profile')->with('success', 'Profil berhasil diperbarui.');
}

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);
    
        $apoteker = apoteker::findOrFail($id); // Pastikan model sesuai
        $apoteker->user->update([
            'password' => Hash::make($request->password),
        ]);
    
        return redirect()->back()->with('success', 'Password berhasil diperbarui.');
    }
}
