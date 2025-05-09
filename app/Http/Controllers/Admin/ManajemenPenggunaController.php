<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengguna;

class ManajemenPenggunaController extends Controller
{
    // Tampilkan daftar semua pengguna
    public function index(Request $request)
    {
        $pengguna = Pengguna::where('peran', 'pengguna')
            ->when($request->q, function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->q . '%');
            })
            ->get();

        return view('admin.pengguna', compact('pengguna'));
    }

    public function show($id)
    {
        $pengguna = Pengguna::findOrFail($id);

        $riwayatPesanan = $pengguna->pesanan()
            ->where('status', 'Selesai')
            ->with('detailPesanan')
            ->get();

        return view('admin.pengguna_show', compact('pengguna', 'riwayatPesanan'));
    }

}
