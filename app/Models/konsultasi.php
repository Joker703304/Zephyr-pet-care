<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class konsultasi extends Model
{
    use HasFactory;

    protected $table = 'konsultasi';
    protected $primaryKey = 'id_konsultasi';

    protected $fillable = [
        'dokter_id', 
        'id_hewan', 
        'keluhan', 
        'tanggal_konsultasi', 
        'status',
        'no_antrian'
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    public function hewan()
    {
        return $this->belongsTo(hewan::class, 'id_hewan');
    }
}
