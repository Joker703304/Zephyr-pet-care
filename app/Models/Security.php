<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Security extends Model
{
    use HasFactory;
    
    protected $table = 'security';

    protected $fillable = [
        'id_user',
        'no_telepon',
        'jenkel',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
