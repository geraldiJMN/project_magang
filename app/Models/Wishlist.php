<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlist';

    protected $primaryKey = 'wishlist_id';

    protected $fillable = [
        'pengguna_id',
        'kopi_id',
    ];

    public $timestamps = false;

    // Relasi ke pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    // Relasi ke kopi
    public function kopi()
    {
        return $this->belongsTo(Kopi::class, 'kopi_id');
    }
}
