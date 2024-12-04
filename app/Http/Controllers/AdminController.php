<?php

namespace App\Http\Controllers;

use App\Models\pemilik_hewan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin'); // Pastikan hanya admin yang bisa akses
    }

    /**
     * Tampilkan halaman dashboard admin.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Dapatkan statistik atau data lainnya yang relevan untuk admin
        $usersCount = User::count();  // Jumlah pengguna
        // $appointmentsCount = \App\Models\Appointment::count();  // Jumlah janji temu
        // $medicationsCount = \App\Models\Obat::count();
        $ownersCount = pemilik_hewan::count();

        return view('admin.dashboard', compact('usersCount', 'ownersCount'));
    }

    // Tambahkan fungsi lain untuk mengelola fitur admin, misalnya:
    public function manageUsers()
    {
        // Ambil semua pengguna untuk dikelola
        $users = User::all();
        return view('admin.user', compact('users'));
    }

    // public function manageObat()
    // {
    //     // Ambil semua pengguna untuk dikelola
    //     $obats = \App\Models\Obat::all();
    //     return view('admin.obat', compact('obats'));
    // }

    public function managePemilik()
    {
        // Ambil semua pengguna untuk dikelola
        $data =pemilik_hewan::all();
        return view('admin.pemilik_hewan', compact('data'));
    }
}
