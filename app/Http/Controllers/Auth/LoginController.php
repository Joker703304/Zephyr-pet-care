<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |----------------------------------------------------------------------
    | Login Controller
    |----------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to their corresponding dashboard based on their role.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home'; // Default redirect route

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override the authenticated method to redirect users based on their role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        if (Gate::allows('admin', $user)) {
            return redirect()->route('admin.dashboard'); // Ganti dengan rute dashboard admin
        } elseif (Gate::allows('dokter', $user)) {
            return redirect()->route('dokter.dashboard'); // Ganti dengan rute dashboard dokter
        } elseif (Gate::allows('apoteker', $user)) {
            return redirect()->route('apoteker.dashboard'); // Ganti dengan rute dashboard apoteker
        } else {
            return redirect()->route('pemilik-hewan.dashboard'); // Ganti dengan rute dashboard pemilik hewan
        }
    }

    /**
     * Override the logout method to log the user out and redirect.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login'); // Ubah dengan rute halaman login
    }
}
