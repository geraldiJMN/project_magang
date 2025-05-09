<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $primaryKey = 'pesanan_id';

    protected $fillable = [
        'pengguna_id',
        'status',
        'metode_pembayaran',
        'bukti_pembayaran',
        'no_resi',
        'total_harga',
    ];

    public $timestamps = true;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = null;

    // Relasi ke pengguna (user yang melakukan pemesanan)
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    // Relasi ke detail pesanan
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }


}
