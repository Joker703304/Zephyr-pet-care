<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/dashboard'; // Ganti sesuai kebutuhan

    public function reset(Request $request)
    {
        // Validasi data input
        $request->validate([
            'phone' => 'required|string|max:13|exists:users,phone',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        // Reset password
        $response = Password::reset(
            $request->only('phone', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Password berhasil diubah!');
        }

        return back()->withErrors(['email' => 'Token tidak valid atau sudah kadaluarsa.']);
    }
}