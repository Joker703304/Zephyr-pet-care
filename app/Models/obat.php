<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class obat extends Model
{
    use HasFactory;

    protected $table = 'obat';

    protected $primaryKey = 'id_obat';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id_obat', 'nama_obat', 'jenis_obat', 'stok', 'harga'];
}
