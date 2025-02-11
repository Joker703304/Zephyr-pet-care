<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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

    public function login(Request $request)
    {
        Log::info('Mencoba login dengan:', [
            'phone' => $request->phone,
            'password' => $request->password
        ]);

        $credentials = $request->only('phone', 'password');

        $user = User::where('phone', $credentials['phone'])->first();

        if (!$user) {
            Log::error('Login gagal: Nomor HP tidak ditemukan.');
            return back()->with('error', 'Login gagal! Nomor HP tidak ditemukan.');
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            Log::error('Login gagal: Password salah.');
            return back()->with('error', 'Login gagal! Password salah.');
        }

        if (!Auth::attempt($credentials)) {
            Log::error('Login gagal: Authentication gagal.');
            return back()->with('error', 'Login gagal! Silakan coba lagi.');
        }

        Log::info('Login berhasil untuk user ID: ' . Auth::id());
        return redirect()->intended($this->redirectTo);
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
        // Redirect berdasarkan role
        if (Gate::allows('admin', $user)) {
            return redirect()->route('admin.dashboard');
        } elseif (Gate::allows('dokter', $user)) {
            return redirect()->route('dokter.dashboard');
        } elseif (Gate::allows('apoteker', $user)) {
            return redirect()->route('apoteker.dashboard');
        } elseif (Gate::allows('kasir', $user)) {
            return redirect()->route('kasir.dashboard');
        }  elseif (Gate::allows('security', $user)) {
            return redirect()->route('security.dashboard');
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
