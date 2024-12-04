<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApotekerController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya pemilik hewan yang dapat mengakses
        $this->middleware('role:apoteker');
    }

    public function index()
    {
        // Menampilkan tampilan dashboard pemilik hewan
        return view('apoteker.dashboard');
    }
}
