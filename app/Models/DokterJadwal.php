<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokterJadwal extends Model
{
    use HasFactory;

    protected $table = 'dokter_jadwal';

    protected $fillable = [
        'id_dokter',
        'tanggal',
        'status',
        'maksimal_konsultasi',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter');
    }
}
