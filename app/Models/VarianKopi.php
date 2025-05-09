<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VarianKopi extends Model
{
    protected $table = 'varian_kopi';

    protected $primaryKey = 'varian_id';

    protected $fillable = [
        'kopi_id',
        'kemasan',
        'gilingan',
    ];

    public $timestamps = false;

    // Relasi ke kopi
    public function kopi()
    {
        return $this->belongsTo(Kopi::class, 'kopi_id');
    }

    // Relasi ke detail pesanan
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'varian_id');
    }

    // Relasi ke keranjang
    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'varian_id');
    }
}
