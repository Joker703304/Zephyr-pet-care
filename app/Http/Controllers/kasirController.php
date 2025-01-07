<?php

namespace App\Http\Controllers;

use App\Models\Kasir;
use App\Models\konsultasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class kasirController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya pemilik hewan yang dapat mengakses
        $this->middleware('role:kasir');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kasir = kasir::where('id_user', Auth::id())->first();

        if (!$kasir) {
            // If no doctor profile exists, redirect to the profile creation page
            return redirect()->route('kasir.createProfile')->with('warning', 'Mohon Isi data diri terlebih dahulu.');
        }

        $konsultasiCount = konsultasi::count();
        // Menampilkan tampilan dashboard pemilik hewan
        return view('kasir.dashboard', compact('konsultasiCount'));;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function createProfile()
    {
        return view('kasir.createProfile');
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
        Kasir::create([
            'id_user' => Auth::id(),
            'no_telepon' => $validated['no_telepon'],
            'jenkel' => $validated['jenkel'],
            'alamat' => $validated['alamat'],
        ]);

        // Redirect to the dashboard after the profile is created
        return redirect()->route('kasir.dashboard')->with('success', 'Profile anda berhasil dibuat.');
    }

    public function editProfile()
    {
        // Get the doctor's profile
        $kasir = Kasir::where('id_user', Auth::id())->first();

        // Return the profile edit view with the doctor's current data
        return view('kasir.editProfile', compact('kasir'));
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
        $apoteker = Kasir::where('id_user', Auth::id())->first();

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
        return redirect()->route('kasir.dashboard')->with('success', 'Profile anda berhasil di perbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
