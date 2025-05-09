<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotifikasiPengguna extends Model
{
    protected $table = 'notifikasi_pengguna';

    protected $primaryKey = 'notifikasi_pengguna_id';

    protected $fillable = [
        'pengguna_id',
        'pesan',
        'sudah_dibaca',
    ];

    public $timestamps = true; // karena ada kolom `dibuat_pada`

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = null;

    // Relasi ke pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}
