<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KonsumenDashboardController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya pemilik hewan yang dapat mengakses
        $this->middleware('role:pemilik_hewan');
    }

    public function index()
    {
        // Menampilkan tampilan dashboard pemilik hewan
        return view('pemilik-hewan.dashboard');
    }
}
