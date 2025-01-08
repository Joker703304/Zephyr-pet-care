<?php

namespace App\Http\Controllers;

use App\Models\Kasir;
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
        'password' => Hash::make($request->password),
        'role' => 'kasir',
    ]);

    // Kirim notifikasi verifikasi email
    $user->sendEmailVerificationNotification();


    return redirect()->route('admin.kasir.index')->with('success', 'kasir berhasil terdaftar.');
}


public function index()
    {
        $kasir = Kasir::with('user')->get();
        return view('admin.kasir.index', compact('kasir'));
    }

    public function create()
    {
        return view('admin.kasir.create');
    }
}
