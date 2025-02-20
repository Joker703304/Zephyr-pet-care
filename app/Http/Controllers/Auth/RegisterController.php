<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OtpCode;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Kirim email verifikasi
        $user->sendEmailVerificationNotification();

        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'phone' => 'required|string|max:13',
            'password' => 'required|string|min:3|confirmed',
            'otp' => 'required|numeric|digits:6',
        ], [
            'otp.digits' => 'OTP harus terdiri dari 6 digit.',
        ]);
        $otpRecord = OtpCode::where('phone', $request->phone)->first();
    
        if (!$otpRecord || $otpRecord->otp != $request->otp) {
            return redirect()->route('register')->with('error', 'OTP tidak valid atau salah.')->withInput();
        }
    
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'phone_verified_at' => now(),
            'password' => bcrypt($request->password), 
            'role' => 'pemilik_hewan',
        ]);
    
        $otpRecord->delete();
    
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}