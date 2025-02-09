<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\hewan;
use App\Models\konsultasi;
use App\Models\obat;
use App\Models\pemilik_hewan;
use App\Models\Transaksi;
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
        $currentMonth = now()->format('Y-m');

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
        $totalThisMonth = Transaksi::where('status_pembayaran', 'dibayar')
        ->where('created_at', 'like', "$currentMonth%")
        ->sum('total_harga');


        return view('admin.dashboard', compact('usersCount', 'ownersCount', 'medicationsCount', 'doctorsCount', 'animalsCount', 'consultationsCount', 'nextQueue', 'totalThisMonth'));
    }

    // Menampilkan pengguna yang belum diverifikasi
    // public function verifyUsers()
    // {
    //     $users = User::where('verified', false)->get();
    //     return view('admin.verify-users', compact('users'));
    // }

    // // Verifikasi pengguna
    // public function approveUser($id)
    // {
    //     $user = User::findOrFail($id);
    //     $user->verified = true; // Set verified ke true
    //     $user->save();

    //     return redirect()->route('admin.verify-users')->with('status', 'Pengguna telah berhasil diverifikasi.');
    // }

      // Menampilkan form untuk mengedit role pengguna
      public function editRole($id)
      {
          $user = User::findOrFail($id);
          return view('admin.edit-role', compact('user')); // Menampilkan form edit role
      }
  
      // Memperbarui role pengguna
      public function updateRole(Request $request, $id)
      {
          $user = User::findOrFail($id);
  
          // Validasi input role
          $validated = $request->validate([
              'role' => 'required|in:admin,dokter,apoteker,pemilik_hewan', // Gantilah sesuai role yang ada
          ]);
  
          $user->role = $validated['role'];
          $user->save();
  
          return redirect()->route('admin.verify-users')->with('status', 'Role pengguna telah berhasil diperbarui.');
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
