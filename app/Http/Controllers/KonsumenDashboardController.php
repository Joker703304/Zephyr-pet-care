<?php

namespace App\Http\Controllers;

use App\Models\hewan;
use App\Models\pemilik_hewan;
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
        // Get the logged-in user
        $user = auth()->user();

        // Check if the user exists in the pemilik_hewan table
        $pemilikHewan = pemilik_hewan::where('email', $user->email)->first();


        // If the user exists, return the dashboard view
        return view('pemilik-hewan.dashboard', compact('pemilikHewan'));
    
    }
}
