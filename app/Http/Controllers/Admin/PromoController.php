<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promo;
use App\Models\Kopi;

class PromoController extends Controller
{
    // Tampilkan semua promo
    public function index()
    {
        $promo = Promo::with('kopi')->get();
        return view('admin.promo.promo', compact('promo'));
    }

    // Form tambah promo
    public function create($kopi_id)
    {
        $kopi = Kopi::findOrFail($kopi_id);
        return view('admin.promo.create', compact('kopi'));
    }


    // Simpan promo baru
    public function store(Request $request)
    {
        $request->validate([
            'kopi_id' => 'required|exists:kopi,kopi_id',
            'diskon_persen' => 'required|numeric|min:0|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        Promo::create($request->all());

        return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil ditambahkan.');
    }

    // Detail promo produk tertentu
    public function showByKopi($kopi_id)
    {
        $promo = Promo::where('kopi_id', $kopi_id)->first();
        $kopi = Kopi::findOrFail($kopi_id);

        return view('admin.promo.promo', compact('promo', 'kopi'));
    }

    // Form edit promo
    public function edit($id)
    {
        $promo = Promo::findOrFail($id);
        $kopiList = Kopi::all();
        return view('admin.promo.edit', compact('promo', 'kopiList'));
    }

    // Update promo
    public function update(Request $request, $id)
    {
        $request->validate([
            'kopi_id' => 'required|exists:kopi,kopi_id',
            'diskon_persen' => 'required|numeric|min:0|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $promo = Promo::findOrFail($id);
        $promo->update($request->all());

        return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil diperbarui.');
    }

    // Hapus promo
    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();

        return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil dihapus.');
    }
}
