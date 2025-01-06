<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function registerStore(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Membuat user baru dengan role dokter
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), // Hashing password
        'role' => 'dokter', // Tetapkan role sebagai dokter
    ]);

    // Kirim notifikasi verifikasi email
    $user->sendEmailVerificationNotification();


    return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil terdaftar.');
}

    public function index()
    {
        $dokters = Dokter::with('user')->get();
        return view('admin.dokter.index', compact('dokters'));
    }


    public function create()
    {
        $users = User::where('role', 'pemilik_hewan')
        ->whereDoesntHave('pemilikHewan')  // Pastikan tidak ada data di tabel pemilik_hewan
        ->get();// Mengambil semua user
    return view('admin.dokter.create', compact('users'));
    }

    public function store(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'spesialis' => 'nullable|string|max:50',
        'no_telepon' => 'required|string|max:20|unique:tbl_dokter,no_telepon',
        'jenkel' => 'required|in:pria,wanita',
        'alamat' => 'required|string|max:255', // Ensure validation includes 'alamat'
    ]);

    $user = User::where('email', $request->email)->first();
    $user->update(['role' => 'dokter']);

    Dokter::create([
        'id_user' => $user->id,
        'spesialis' => $request->spesialis,
        'no_telepon' => $request->no_telepon,
        'jenkel' => $request->jenkel,
        'alamat' => $request->alamat, // Include 'alamat'
    ]);

    return redirect()->route('admin.dokter.index')->with('success', 'Doctor added successfully.');
}




    public function findUserByEmail(Request $request)
{
    $email = $request->input('email');
    $user = User::where('email', $email)->first();

    if ($user) {
        return response()->json([
            'name' => $user->name,
        ]);
    }

    return response()->json([
        'message' => 'User not found.',
    ], 404);
}


    public function edit($id)
{
    $dokter = Dokter::findOrFail($id);
    $users = User::where('role', 'pemilik_hewan')->orWhere('id', $dokter->id_user)->get();

    return view('admin.dokter.edit', compact('dokter', 'users'));
}

public function update(Request $request, $id)
{
    // Validate the form input
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'spesialis' => 'nullable|string|max:50',
        'no_telepon' => 'required|string|max:20|unique:tbl_dokter,no_telepon,' . $id,
        'jenkel' => 'required|in:pria,wanita',
        'alamat' => 'required|string|max:255',
    ]);

    // Find the dokter by ID
    $dokter = Dokter::findOrFail($id);

    // Find the user based on the selected email
    $user = User::where('email', $request->email)->first();

    // Update user role if changed
    if ($dokter->id_user !== $user->id) {
        // Update the old user's role to 'pemilik_hewan'
        $oldUser = User::findOrFail($dokter->id_user);
        $oldUser->update(['role' => 'pemilik_hewan']);

        // Update the new user's role to 'dokter'
        $user->update(['role' => 'dokter']);
    }

    // Update dokter details
    $dokter->update([
        'id_user' => $user->id,
        'spesialis' => $request->spesialis,
        'no_telepon' => $request->no_telepon,
        'jenkel' => $request->jenkel,
        'alamat' => $request->alamat,
    ]);

    // Redirect with success message
    return redirect()->route('admin.dokter.index')->with('success', 'Doctor updated successfully.');
}

public function destroy($id)
{
    $dokter = Dokter::findOrFail($id);

    // Change the role of the associated user back to "pemilik_hewan"
    $user = User::findOrFail($dokter->id_user);
    $user->update(['role' => 'pemilik_hewan']);

    $dokter->delete();

    return redirect()->route('admin.dokter.index')->with('success', 'Doctor deleted successfully.');
}

}
