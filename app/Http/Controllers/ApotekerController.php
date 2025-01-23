<?php

namespace App\Http\Controllers;

use App\Models\Apoteker;
use Illuminate\Http\Request;
use App\Models\obat;
use App\Models\ResepObat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            // Jika data apoteker tidak ada, redirect untuk membuat profil
            return redirect()->route('apoteker.createProfile')->with('warning', 'Mohon Isi data diri terlebih dahulu.');
        }

        // Hitung jumlah obat terdaftar
        $medicationsCount = obat::count();

        // Hitung jumlah resep obat berdasarkan id_konsultasi yang unik dengan status sedang disiapkan
        $prescriptions = ResepObat::where('status', 'sedang di siapkan') // Filter hanya status sedang disiapkan
                                    ->distinct('id_konsultasi') // Hanya hitung id_konsultasi unik
                                    ->count('id_konsultasi'); // Hitung jumlah id_konsultasi

        // Menampilkan tampilan dashboard apoteker
        return view('apoteker.dashboard', compact('medicationsCount', 'prescriptions'));
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
        return view('apoteker.createProfile');
    }

    public function storeProfile(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'no_telepon' => 'required|string|max:20|unique:apotekers',
            'jenkel' => 'required|in:pria,wanita',
            'alamat' => 'nullable|string',
        ]);

        // Create a new doctor profile
        Apoteker::create([
            'id_user' => Auth::id(),
            'no_telepon' => $validated['no_telepon'],
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
        // Validate the incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',  // Menambahkan validasi untuk name
            'no_telepon' => 'required|string|max:20|unique:apotekers,no_telepon,' . Auth::id() . ',id_user',
            'jenkel' => 'required|in:pria,wanita',
            'alamat' => 'nullable|string',
        ]);

        // Temukan dokter berdasarkan id_user (auth)
        $apoteker = Apoteker::where('id_user', Auth::id())->first();

        // Update nama pengguna
        $apoteker->user->update([
            'name' => $validated['name'],
        ]);

        // Update data dokter
        $apoteker->update([
            'no_telepon' => $validated['no_telepon'],
            'jenkel' => $validated['jenkel'],
            'alamat' => $validated['alamat'],
        ]);

        // Redirect to the dashboard after the profile is updated
        return redirect()->route('apoteker.profile')->with('success', 'Profile Anda Berhasil Di Perbarui.');
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
