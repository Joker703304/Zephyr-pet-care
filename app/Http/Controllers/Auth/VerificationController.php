<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

public function verify(Request $request)
{
    // Cari user berdasarkan ID
    $user = User::findOrFail($request->route('id'));

    // Validasi hash email
    $expectedHash = sha1($user->getEmailForVerification());
    if (!hash_equals((string) $request->route('hash'), $expectedHash)) {
        abort(403, 'Invalid verification link.');
    }

    // Perbarui status verifikasi jika belum terverifikasi
    if (!$user->hasVerifiedEmail()) {
        $user->email_verified_at = now();
        $user->save();
    
        event(new Verified($user));
    }

    // Redirect ke halaman yang diinginkan dengan pesan sukses
    return redirect($this->redirectPath())->with('verified', true);
}

}
