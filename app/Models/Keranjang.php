<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';

    protected $primaryKey = 'keranjang_id';

    protected $fillable = [
        'pengguna_id',
        'varian_id',
        'jumlah',
    ];

    public $timestamps = false;

    // Relasi ke tabel Pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    // Relasi ke tabel VarianKopi
    public function varian()
    {
        return $this->belongsTo(VarianKopi::class, 'varian_id');
    }
}
