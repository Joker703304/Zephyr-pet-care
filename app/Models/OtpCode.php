<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OtpCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'phone',
        'otp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function isOtpValid($otp)
    {
        return $this->otp === $otp && Carbon::parse($this->otp_created_at)->addMinutes(5)->isFuture();
    }

}
