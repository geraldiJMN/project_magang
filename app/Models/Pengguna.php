<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';

    protected $primaryKey = 'pengguna_id';

    protected $fillable = [
        'nama',
        'email',
        'kata_sandi',
        'peran',
    ];

    public $timestamps = true;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = null;

    // Override nama kolom password agar sesuai dengan database
    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }

    // Relasi ke pesanan
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'pengguna_id');
    }

    // Relasi ke notifikasi
    public function notifikasi()
    {
        return $this->hasMany(NotifikasiPengguna::class, 'pengguna_id');
    }

    // Relasi ke ulasan
    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'pengguna_id');
    }

    // Relasi ke keranjang
    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'pengguna_id');
    }

    // Relasi ke wishlist
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'pengguna_id');
    }
}
