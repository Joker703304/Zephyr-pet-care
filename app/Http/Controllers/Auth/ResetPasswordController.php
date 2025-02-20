<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/dashboard'; // Ganti sesuai kebutuhan

    public function showResetForm(Request $request)
    {
        $phone = $request->query('phone');

        if (!$phone) {
            return redirect()->route('password.forgot')->with('error', 'Nomor HP tidak ditemukan.');
        }

        return view('auth.passwords.reset', compact('phone'));
    }

    public function reset(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric|digits_between:10,13|exists:users,phone',
            'otp' => 'required|numeric',
            'password' => 'required|min:8|confirmed',
        ]);

        $otpCode = OtpCode::where('phone', $request->phone)->first();

        // Cek apakah OTP valid
        if (!$otpCode || !$otpCode->isOtpValid($request->otp)) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
        }

        // Update password user
        $user = User::where('phone', $request->phone)->first();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Hapus OTP setelah digunakan
        $otpCode->delete();

        // Hapus session nomor HP
        session()->forget('reset_phone');

        return redirect()->route('login')->with('success', 'Password berhasil diubah!');
    }

}