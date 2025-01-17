<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'id_konsultasi',
        'total_harga',
        'status_pembayaran', // Status: "belum dibayar", "dibayar"
        'jumlah_bayar',      // Uang yang diterima
        'kembalian',         // Uang kembalian
    ];

    public function konsultasi()
    {
        return $this->belongsTo(Konsultasi::class, 'id_konsultasi');
    }

    public function rincianObat()
{
    return $this->hasManyThrough(ResepObat::class, Konsultasi::class, 'id_konsultasi', 'id_konsultasi');
}

public function rincianLayanan()
{
    return $this->hasManyThrough(Layanan::class, Konsultasi::class, 'id_konsultasi', 'id_layanan', 'id_konsultasi', 'id_layanan');
}

}
