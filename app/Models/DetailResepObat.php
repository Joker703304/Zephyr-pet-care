<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailResepObat extends Model
{
    use HasFactory;

    // Define the table name if it's not the plural form of the model name
    protected $table = 'detail_resep_obat';

    // Define the primary key, if it is not 'id'
    protected $primaryKey = 'id';

    // Specify which attributes can be mass-assigned
    protected $fillable = [
        'id_resep',
        'id_obat',
        'tanggal_resep',
        'status',
        'jumlah',
    ];

    // Define the relationships
    public function resep()
    {
        return $this->belongsTo(ResepObat::class, 'id_resep');
    }

    public function obat()
    {
        return $this->belongsTo(obat::class, 'id_obat');
    }
}
