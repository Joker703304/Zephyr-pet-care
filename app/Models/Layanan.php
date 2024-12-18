<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Layanan extends Model
{
    use HasFactory;

    // Define the table name if it differs from the pluralized model name
    protected $table = 'layanan';

    // Define the primary key (if not 'id')
    protected $primaryKey = 'id_layanan';

    // Define the attributes that are mass assignable
    protected $fillable = [
        'nama_layanan',
        'deskripsi',
        'harga',
    ];

}
