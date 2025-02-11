<?php

namespace App\Http\Controllers;

use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CodeOtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        // Validasi nomor telepon
        $request->validate([
            'phone' => 'required|numeric|digits_between:10,13',
        ]);

        $phone = $request->phone;

        // Cek apakah nomor telepon sudah ada
        if (User::where('phone', $phone)->exists()) {
            return response()->json(['success' => false, 'message' => 'Nomor telepon sudah terdaftar!'], 409);
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        try {
            // Simpan atau perbarui OTP
            OtpCode::updateOrCreate(
                ['phone' => $phone],
                ['otp' => $otp, 'created_at' => now()]
            );

            // API Japati
            $apiToken = 'API-TOKEN-3Kf4h51x2zIfh2Si2fd8LMorPfs5T9JXKiqYv1dnaT1hvwMWXs8crl';
            $gateway = '6288229193849';

            // Kirim OTP
            $response = Http::withToken($apiToken)->post('http://app.japati.id/api/send-message', [
                'gateway' => $gateway,
                'number' => $phone,
                'type' => 'text',
                'message' => "*$otp* adalah kode verifikasi Anda.",
            ]);

            if ($response->failed()) {
                Log::error('Gagal mengirim OTP: ' . $response->body());
                return response()->json(['success' => false, 'message' => 'Gagal mengirim OTP.'], 500);
            }

            return response()->json(['success' => true, 'message' => 'OTP berhasil dikirim!']);

        } catch (\Exception $e) {
            Log::error('Error saat mengirim OTP: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat mengirim OTP.'], 500);
        }
    }
}