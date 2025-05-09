<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $table = 'ulasan';

    protected $primaryKey = 'ulasan_id';

    protected $fillable = [
        'pengguna_id',
        'kopi_id',
        'rating',
        'komentar',
        'komentar_terbaik',
    ];

    public $timestamps = true;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = null;

    // Relasi ke pengguna (yang memberi ulasan)
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    // Relasi ke kopi (yang diulas)
    public function kopi()
    {
        return $this->belongsTo(Kopi::class, 'kopi_id');
    }
}
