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

    protected $fillable = ['id_pemilik', 'nama', 'email', 'jenkel', 'alamat', 'no_tlp'];

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email'); // foreignKey, ownerKey
    }
}
