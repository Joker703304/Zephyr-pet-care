<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'tbl_dokter';

    protected $fillable = [
        'id_user',
        'spesialis',
        'no_telepon',
        'jenkel',
        'alamat',
        
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function konsultasi()
    {
        return $this->hasMany(Konsultasi::class, 'dokter_id');
    }
}
