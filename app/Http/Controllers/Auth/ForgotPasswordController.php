<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OtpCode;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric|digits_between:10,13|exists:users,phone',
        ]);

        $otp = rand(100000, 999999);

        // Cek apakah OTP sudah ada untuk nomor ini
        $otpCode = OtpCode::where('phone', $request->phone)->first();

        if ($otpCode) {
            // Perbarui OTP yang sudah ada
            $otpCode->update([
                'otp' => $otp,
                'otp_created_at' => now(),
            ]);
        } else {
            // Buat OTP baru
            OtpCode::create([
                'phone' => $request->phone,
                'otp' => $otp,
                'otp_created_at' => now(),
            ]);
        }

        // Kirim OTP via API Japati
        try {
            $apiToken = 'API-TOKEN-3Kf4h51x2zIfh2Si2fd8LMorPfs5T9JXKiqYv1dnaT1hvwMWXs8crl';
            $gateway = '6288229193849';

            $response = Http::withToken($apiToken)->post('http://app.japati.id/api/send-message', [
                'gateway' => $gateway,
                'number' => $request->phone,
                'type' => 'text',
                'message' => "*$otp* adalah kode verifikasi Anda.",
            ]);

            if ($response->failed()) {
                Log::error('Gagal mengirim OTP: ' . $response->body());
                return back()->with('error', 'Gagal mengirim OTP.');
            }

            // Simpan nomor HP dalam session agar bisa digunakan di halaman reset password
            session(['reset_phone' => $request->phone]);

            return redirect()->route('password.reset.form', ['phone' => $request->phone])
                ->with('success', 'OTP telah dikirim ke WhatsApp Anda.');
        } catch (\Exception $e) {
            Log::error('Error saat mengirim OTP: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengirim OTP.');
        }
    }
}
