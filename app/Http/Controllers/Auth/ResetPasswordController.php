<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/login'; // Ubah jika perlu

    /**
     * Reset the user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request)
    {
        // Validasi input
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Ambil data pengguna berdasarkan email dan token
        $credentials = $request->only('email', 'password', 'password_confirmation', 'token');

        // Lakukan reset password menggunakan token
        $response = Password::reset($credentials, function ($user) use ($request) {
            // Set password baru untuk pengguna
            $user->password = bcrypt($request->password);
            $user->save();
        });

        // Tangani hasil dari proses reset
        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Password telah berhasil direset, silakan login.');
        } else {
            return back()->withErrors(['email' => 'Gagal mereset password. Pastikan token valid.']);
        }
    }
}
