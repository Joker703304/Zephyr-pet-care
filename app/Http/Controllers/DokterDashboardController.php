<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DokterDashboardController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya pemilik hewan yang dapat mengakses
        $this->middleware('role:dokter');
    }

    public function dokter()
    {
        // Menampilkan tampilan dashboard pemilik hewan
        return view('dokter.dashboard');
    }
}
