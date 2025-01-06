<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\konsultasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class KasirAdminController extends Controller
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
        'role' => 'kasir', // Tetapkan role sebagai dokter
    ]);

    // Kirim notifikasi verifikasi email
    $user->sendEmailVerificationNotification();


    return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil terdaftar.');
}

public function index()
{
    $today = now()->toDateString();  // Dapatkan tanggal hari ini
$konsultasi = Konsultasi::with(['dokter', 'hewan'])
    ->whereDate('tanggal_konsultasi', $today)  // Filter hanya untuk tanggal konsultasi hari ini
    ->get();

if (auth()->user()->role == 'pemilik_hewan') {
    return view('pemilik-hewan.konsultasi.index', compact('konsultasi'));
}

return view('kasir.konsultasi.index', compact('konsultasi'));
}
}
