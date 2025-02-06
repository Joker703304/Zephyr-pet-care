<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisHewan extends Model
{
    use HasFactory;

    protected $table = 'jenis_hewan';
    protected $fillable = ['nama_jenis'];

    public function hewan()
    {
        return $this->hasMany(Hewan::class, 'jenis_id');
    }
}
