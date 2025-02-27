<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;

    protected $table = 'antrian';

    protected $fillable = [
        'konsultasi_id', 
        'no_antrian', 
        'status'
    ];

    // Relasi dengan model Konsultasi
    public function konsultasi()
    {
        return $this->belongsTo(konsultasi::class, 'konsultasi_id', 'id_konsultasi');
    }
}

