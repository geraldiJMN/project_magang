<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kopi extends Model
{
    protected $table = 'kopi';
    protected $primaryKey = 'kopi_id';
    public $timestamps = false;

    protected $fillable = [
        'nama', 'deskripsi', 'asal', 'profil_rasa', 'catatan_seduh',
        'harga', 'stok', 'kategori', 'url_gambar', 'dibuat_pada'
    ];

    public function promo()
    {
        return $this->hasOne(Promo::class, 'kopi_id');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'kopi_id');
    }
}
