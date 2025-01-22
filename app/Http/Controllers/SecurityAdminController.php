<?php

namespace App\Http\Controllers;

use App\Models\Kasir;
use App\Models\User;
use App\Models\konsultasi;
use App\Models\Security;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class SecurityAdminController extends Controller
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
        'role' => 'security',
    ]);

    // Kirim notifikasi verifikasi email
    $user->sendEmailVerificationNotification();


    return redirect()->route('admin.security.index')->with('success', 'security berhasil terdaftar.');
}


public function index()
    {
        $security = Security::with('user')->get();
        return view('admin.security.index', compact('security'));
    }

    public function create()
    {
        return view('admin.security.create');
    }
}
