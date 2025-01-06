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
        'no_antrian',
        'dokter_id',
        'id_hewan',
        'keluhan',
        'tanggal_konsultasi',
        'diagnosis',
        'layanan_id',
        'status'
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    public function hewan()
    {
        return $this->belongsTo(hewan::class, 'id_hewan');
    }

    public function resepObat()
    {
        return $this->hasMany(ResepObat::class, 'id_konsultasi', 'id_konsultasi');
    }

    public static function getDailyCount($tanggal_konsultasi)
    {
        return self::where('tanggal_konsultasi', $tanggal_konsultasi)->count();
    }

    public function user()
{
    return $this->hasOneThrough(User::class, hewan::class);
}

public function layanan()
{
    return $this->belongsToMany(Layanan::class, 'konsultasi_layanan', 'id_konsultasi', 'id_layanan');
}

}
