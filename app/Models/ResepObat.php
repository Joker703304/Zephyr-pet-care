<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResepObat extends Model
{
    use HasFactory;

    protected $table = 'resep_obat';
    protected $primaryKey = 'id_resep';

    protected $fillable = [
        'id_konsultasi',
        'id_obat',
        'jumlah',
        'keterangan',
    ];

    // Relasi ke Konsultasi
    public function konsultasi()
    {
        return $this->belongsTo(Konsultasi::class, 'id_konsultasi');
    }

    // Relasi ke Obat
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }
}
