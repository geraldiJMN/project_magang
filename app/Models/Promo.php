<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $table = 'promo';

    protected $primaryKey = 'promo_id';

    protected $fillable = [
        'kopi_id',
        'diskon_persen',
        'tanggal_mulai',
        'tanggal_berakhir',
    ];

    public $timestamps = false; // karena tabel tidak memiliki created_at atau updated_at

    // Relasi ke kopi
    public function kopi()
    {
        return $this->belongsTo(Kopi::class, 'kopi_id');
    }
}
