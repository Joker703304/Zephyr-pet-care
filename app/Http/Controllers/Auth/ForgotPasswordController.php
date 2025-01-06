<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{
    /*
    |----------------------------------------------------------------------
    | Password Reset Controller
    |----------------------------------------------------------------------
    |
    | Controller ini bertanggung jawab untuk menangani email reset password
    | dan termasuk trait yang membantu mengirimkan pemberitahuan reset password
    | dari aplikasi kamu kepada pengguna.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Mengirimkan tautan reset password ke email pengguna.
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Validasi email
        $request->validate(['email' => 'required|email']);

        // Mengirim tautan reset password
        $response = Password::sendResetLink($request->only('email'));

        // Jika pengiriman sukses, arahkan ke halaman reset password dengan pesan sukses
        if ($response == Password::RESET_LINK_SENT) {
            return redirect()->route('login')->with('status', 'Kami telah mengirimkan tautan reset password ke email Anda!');
        }

        // Jika gagal, kembali dengan pesan error
        return back()->withErrors(['email' => trans($response)]);
    }
}
