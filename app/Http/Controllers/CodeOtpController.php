<?php

namespace App\Http\Controllers;

use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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

    public function sendOtpChangeNumber(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric|digits_between:10,13',
        ]);

        $phone = $request->phone;

        // Cek apakah nomor telepon sudah digunakan oleh pengguna lain
        if (User::where('phone', $phone)->exists()) {
            return response()->json(['success' => false, 'message' => 'Nomor telepon sudah terdaftar!'], 409);
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        try {
            // Simpan OTP ke database
            OtpCode::updateOrCreate(
                ['phone' => $phone],
                ['otp' => $otp, 'created_at' => now()]
            );

            // Kirim OTP via API Japati
            $apiToken = 'API-TOKEN-3Kf4h51x2zIfh2Si2fd8LMorPfs5T9JXKiqYv1dnaT1hvwMWXs8crl';
            $gateway = '6288229193849';

            $response = Http::withToken($apiToken)->post('http://app.japati.id/api/send-message', [
                'gateway' => $gateway,
                'number' => $phone,
                'type' => 'text',
                'message' => "*$otp* adalah kode verifikasi Anda untuk mengubah nomor HP.",
            ]);

            if ($response->failed()) {
                return response()->json(['success' => false, 'message' => 'Gagal mengirim OTP.'], 500);
            }

            return response()->json(['success' => true, 'message' => 'OTP berhasil dikirim!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan.'], 500);
        }
    }

    public function verifyOtpChangeNumber(Request $request)
{
    $request->validate([
        'phone' => 'required|numeric|digits_between:10,13',
        'otp' => 'required|numeric',
    ]);

    $otpCode = OtpCode::where('phone', $request->phone)->first();

    if (!$otpCode || $otpCode->otp !== $request->otp) {
        return response()->json(['success' => false, 'message' => 'OTP tidak valid atau sudah kedaluwarsa.']);
    }

    $user = Auth::user();
    $oldPhone = $user->phone; // Simpan nomor lama

    if ($oldPhone === $request->phone) {
        return response()->json(['success' => false, 'message' => 'Nomor HP sudah digunakan.']);
    }

    // Update nomor HP pengguna
    $user->update(['phone' => $request->phone]);

    // Hapus OTP setelah berhasil digunakan
    $otpCode->delete();

    try {
        // Kirim notifikasi ke nomor lama
        $apiToken = 'API-TOKEN-3Kf4h51x2zIfh2Si2fd8LMorPfs5T9JXKiqYv1dnaT1hvwMWXs8crl';
        $gateway = '6288229193849';

        $message = "Nomor HP Anda telah berhasil diganti ke *{$request->phone}* di website Zephyr Pet. Jika ini bukan Anda, segera hubungi admin.";

        $response = Http::withToken($apiToken)->post('http://app.japati.id/api/send-message', [
            'gateway' => $gateway,
            'number' => $oldPhone, // Kirim ke nomor lama
            'type' => 'text',
            'message' => $message,
        ]);

        if ($response->failed()) {
            return response()->json(['success' => false, 'message' => 'Nomor HP berhasil diubah, tetapi gagal mengirim notifikasi ke nomor lama.']);
        }
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Nomor HP berhasil diubah, tetapi terjadi kesalahan saat mengirim notifikasi.']);
    }

    return response()->json(['success' => true, 'message' => 'Nomor HP berhasil diubah dan notifikasi telah dikirim ke nomor lama.']);
}


    public function sendOtpChangePassword(Request $request)
{
    $user = Auth::user();
    $phone = $user->phone;

    if (!$phone) {
        return response()->json(['success' => false, 'message' => 'Nomor HP tidak ditemukan.'], 400);
    }

    $otp = rand(100000, 999999);

    try {
        OtpCode::updateOrCreate(
            ['phone' => $phone],
            ['otp' => $otp, 'created_at' => now()]
        );

        $apiToken = 'API-TOKEN-3Kf4h51x2zIfh2Si2fd8LMorPfs5T9JXKiqYv1dnaT1hvwMWXs8crl';
        $gateway = '6288229193849';

        $response = Http::withToken($apiToken)->post('http://app.japati.id/api/send-message', [
            'gateway' => $gateway,
            'number' => $phone,
            'type' => 'text',
            'message' => "*$otp* adalah kode verifikasi Anda untuk mengganti password.",
        ]);

        if ($response->failed()) {
            return response()->json(['success' => false, 'message' => 'Gagal mengirim OTP.'], 500);
        }

        return response()->json(['success' => true, 'message' => 'OTP berhasil dikirim!', 'phone' => $phone]);

    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Terjadi kesalahan.'], 500);
    }
}

public function verifyOtpChangePassword(Request $request)
{
    Log::info('verifyOtpChangePassword: Memulai proses verifikasi OTP.', ['request' => $request->all()]);

    $request->validate([
        'phone' => 'required|numeric|digits_between:10,13',
        'otp' => 'required|numeric',
        'password' => 'required|min:6|confirmed',
    ]);

    Log::info('verifyOtpChangePassword: Request validasi berhasil.');

    $otpCode = OtpCode::where('phone', $request->phone)->first();

    if (!$otpCode) {
        Log::error('verifyOtpChangePassword: OTP tidak ditemukan.', ['phone' => $request->phone]);
        return response()->json(['success' => false, 'message' => 'OTP tidak valid atau sudah kedaluwarsa.']);
    }

    if ($otpCode->otp !== $request->otp) {
        Log::error('verifyOtpChangePassword: OTP tidak cocok.', [
            'phone' => $request->phone, 
            'input_otp' => $request->otp, 
            'stored_otp' => $otpCode->otp
        ]);
        return response()->json(['success' => false, 'message' => 'OTP tidak valid atau sudah kedaluwarsa.']);
    }

    // Cari user berdasarkan nomor HP, bukan Auth::user()
    $user = User::where('phone', $request->phone)->first();
    
    if (!$user) {
        Log::error('verifyOtpChangePassword: User tidak ditemukan.', ['phone' => $request->phone]);
        return response()->json(['success' => false, 'message' => 'User tidak ditemukan.']);
    }

    $user->update(['password' => bcrypt($request->password)]);
    Log::info('verifyOtpChangePassword: Password berhasil diubah.', ['user_id' => $user->id]);

    Log::info('verifyOtpChangePassword: Sebelum menghapus OTP.', ['otp_id' => $otpCode->id]);
    $otpCode->delete();
    Log::info('verifyOtpChangePassword: Setelah menghapus OTP.');

    return response()->json(['success' => true, 'message' => 'Password berhasil diubah!']);
}


}