<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $fillable = ['id_konsultasi', 'layanan_id', 'diagnosis'];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }

    public function konsultasi()
    {
        return $this->belongsTo(konsultasi::class, 'id_konsultasi');
    }
}
