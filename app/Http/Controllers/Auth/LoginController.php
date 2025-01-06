<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
    }

    /**
     * Override the authenticated method to handle email verification and role-based redirection.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        //Cek apakah email sudah diverifikasi
        if (!$user->hasVerifiedEmail()) {
            Auth::logout();
            return redirect('/login')->with('error', 'Email Anda belum diverifikasi. Silakan cek email Anda untuk verifikasi.');
        }

        // Redirect berdasarkan role
        if (Gate::allows('admin', $user)) {
            return redirect()->route('admin.dashboard');
        } elseif (Gate::allows('dokter', $user)) {
            return redirect()->route('dokter.dashboard');
        } elseif (Gate::allows('apoteker', $user)) {
            return redirect()->route('apoteker.dashboard');
        } elseif ($user->role == 'kasir' && !$user->profile) {
            // Jika pengguna adalah pemilik hewan dan belum mengisi profil, arahkan ke halaman create profil
            return redirect()->route('kasir.pemilik_hewan.create');
        } else {
            // Jika pengguna pemilik hewan sudah memiliki profil atau role lain, arahkan ke dashboard pemilik hewan
            return redirect()->route('pemilik-hewan.dashboard');
        }
    }

    /**
     * Override the logout method to log the user out and redirect.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda berhasil logout.');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
