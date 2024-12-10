<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hewan extends Model
{
    use HasFactory;

    protected $table = 'hewan';

    protected $primaryKey = 'id_hewan';

    protected $fillable = [
        'id_pemilik',
        'nama_hewan',
        'jenis',
        'jenkel',
        'umur',
        'berat',
        'foto',
    ];

    public function pemilik()
    {
        return $this->belongsTo(pemilik_hewan::class, 'id_pemilik', 'id_pemilik');
    }

    public function konsultasi()
    {
        return $this->hasMany(Konsultasi::class, 'id_hewan');
    }
}
