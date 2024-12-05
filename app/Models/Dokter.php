<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'tbl_dokter';

    protected $fillable = [
        'nama',
        'spesialis',
        'no_telepon',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];
}
