<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\hewan;
use App\Models\konsultasi;
use App\Models\obat;
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
        $today = now()->toDateString();

        // Cari antrian berikutnya
        $nextQueue = Konsultasi::whereDate('tanggal_konsultasi', $today)
            ->whereIn('status', ['Menunggu', 'Sedang Diproses'])
            ->orderBy('no_antrian')
            ->first();
        // Dapatkan statistik atau data lainnya yang relevan untuk admin
        $usersCount = User::count();  // Jumlah pengguna
        // $appointmentsCount = \App\Models\Appointment::count();  // Jumlah janji temu
        $medicationsCount = obat::count();
        $ownersCount = pemilik_hewan::count();
        $doctorsCount = Dokter::count();
        $animalsCount = hewan::count();
        $consultationsCount = konsultasi::count();


        return view('admin.dashboard', compact('usersCount', 'ownersCount', 'medicationsCount', 'doctorsCount', 'animalsCount', 'consultationsCount', 'nextQueue'));
    }

    // Tambahkan fungsi lain untuk mengelola fitur admin, misalnya:
    public function manageUsers()
    {
        // Ambil semua pengguna untuk dikelola
        $users = User::all();
        return view('admin.user', compact('users'));
    }

    public function manageObat()
    {
        // Ambil semua pengguna untuk dikelola
        $obats = Obat::all();
        return view('admin.obat', compact('obats'));
    }

    public function managePemilik()
    {
        // Ambil semua pengguna untuk dikelola
        $data = pemilik_hewan::all();
        return view('admin.pemilik_hewan', compact('data'));
    }

    public function manageDokter()
    {
        // Ambil semua pengguna untuk dikelola
        $dokters = Dokter::all();
        return view('admin.Dokter', compact('dokters'));
    }

    public function manageHewan()
    {
        // Ambil semua pengguna untuk dikelola
        $hewan = hewan::all();
        return view('admin.hewan', compact('hewan'));
    }

    public function manageKonsultasi()
    {
        // Ambil semua pengguna untuk dikelola
        $konsultasi = konsultasi::all();
        return view('admin.konsultasi', compact('konsultasi'));
    }
}
