<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\obat;
use App\Models\ResepObat;

class ApotekerController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya pemilik hewan yang dapat mengakses
        $this->middleware('role:apoteker');
    }

    public function index()
    {
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
}
