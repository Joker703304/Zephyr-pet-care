<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        if (Gate::allows('admin', $user)) {
            return redirect()->route('admin.dashboard');
        } elseif (Gate::allows('dokter', $user)) {
            return redirect()->route('dokter.dashboard');
        } elseif (Gate::allows('apoteker', $user)) {
            return redirect()->route('apoteker.dashboard');
        } elseif (Gate::allows('kasir', $user)) {
            return redirect()->route('kasir.dashboard');
        } elseif (Gate::allows('security', $user)) {
            return redirect()->route('security.dashboard');
        } else {
            return redirect()->route('pemilik-hewan.dashboard');
        }
    }
}
