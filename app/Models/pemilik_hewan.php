<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pemilik_hewan extends Model
{
    use HasFactory;
    protected $table = 'pemilik_hewan';

    protected $primaryKey = 'id_pemilik';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id_pemilik', 'id_user', 'nama', 'jenkel', 'alamat', 'no_tlp'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function hewan()
{
    return $this->hasOne(hewan::class, 'id_pemilik', 'id_pemilik');
}

public function konsultasi()
{
    return $this->hasMany(konsultasi::class);
}

public function konsultasiMenunggu()
{
    return $this->konsultasi()->where('status', 'menunggu');
}


}
