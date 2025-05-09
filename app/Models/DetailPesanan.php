<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';

    protected $primaryKey = 'detail_pesanan_id';

    protected $fillable = [
        'pesanan_id',
        'varian_id',
        'jumlah',
        'harga',
    ];

    public $timestamps = false; // karena tidak ada kolom created_at / updated_at

    // Relasi ke tabel Pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    // Relasi ke tabel VarianKopi
    public function varian()
    {
        return $this->belongsTo(VarianKopi::class, 'varian_id');
    }
}
