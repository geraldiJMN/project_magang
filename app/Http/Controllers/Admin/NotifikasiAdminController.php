<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\VarianKopi;

class NotifikasiAdminController extends Controller
{
    // Tampilkan semua notifikasi admin
    public function index()
    {
        // Pesanan baru (status: Belum Dibayar atau Diproses)
        $pesananBaru = Pesanan::whereIn('status', ['Belum Dibayar', 'Diproses'])->latest()->get();

        // Stok hampir habis (misal < 10)
        $stokMenipis = VarianKopi::with('kopi')
            ->where('stok', '<', 10)
            ->orderBy('stok', 'asc')
            ->get();

        return view('admin.notifikasi.index', compact('pesananBaru', 'stokMenipis'));
    }
}
