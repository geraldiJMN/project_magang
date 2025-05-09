<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VarianKopi;
use App\Models\Kopi;

class ManajemenStokController extends Controller
{
    // Tampilkan daftar semua varian kopi dan stoknya
    public function index()
    {
        $varian = VarianKopi::with('kopi')->orderBy('kopi_id')->get();
        return view('admin.stok.index', compact('varian'));
    }

    // Form edit stok varian tertentu
    public function edit($id)
    {
        $varian = VarianKopi::with('kopi')->findOrFail($id);
        return view('admin.stok.edit', compact('varian'));
    }

    // Update jumlah stok
    public function update(Request $request, $id)
    {
        $request->validate([
            'stok' => 'required|integer|min:0',
        ]);

        $varian = VarianKopi::findOrFail($id);
        $varian->stok = $request->stok;
        $varian->save();

        return redirect()->route('admin.stok.index')->with('success', 'Stok berhasil diperbarui.');
    }
}
