<?php

namespace App\Http\Controllers;

use App\Models\Apoteker;
use Illuminate\Http\Request;
use App\Models\obat;
use App\Models\ResepObat;
use Illuminate\Support\Facades\Auth;

class ApotekerController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya pemilik hewan yang dapat mengakses
        $this->middleware('role:apoteker');
    }

    public function index()
    {
        $apoteker = Apoteker::where('id_user', Auth::id())->first();

        if (!$apoteker) {
            // If no doctor profile exists, redirect to the profile creation page
            return redirect()->route('apoteker.createProfile')->with('warning', 'Please complete your profile first.');
        }

        $medicationsCount = obat::count();
        $prescriptions = ResepObat::count();
        // Menampilkan tampilan dashboard pemilik hewan
        return view('apoteker.dashboard', compact('medicationsCount', 'prescriptions'));
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
        'spesialis' => 'required|string|max:50',
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
    return redirect()->route('apoteker.dashboard')->with('success', 'Your profile has been updated successfully.');
}

}
