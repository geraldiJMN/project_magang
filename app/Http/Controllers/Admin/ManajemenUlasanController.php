<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ulasan;

class ManajemenUlasanController extends Controller
{
    // Tampilkan semua ulasan
    public function index()
    {
        $ulasan = Ulasan::with(['pengguna', 'kopi'])->latest('dibuat_pada')->get();
        return view('admin.ulasan', compact('ulasan'));
    }

    // Update status komentar terbaik
    public function update(Request $request, $id)
    {
        $request->validate([
            'komentar_terbaik' => 'required|in:ya,tidak',
        ]);

        $ulasan = Ulasan::findOrFail($id);
        $ulasan->komentar_terbaik = $request->komentar_terbaik;
        $ulasan->save();

        return redirect()->route('admin.ulasan.index')->with('success', 'Status komentar terbaik diperbarui.');
    }

    // Hapus ulasan
    public function destroy($id)
    {
        $ulasan = Ulasan::findOrFail($id);
        $ulasan->delete();

        return redirect()->route('admin.ulasan.index')->with('success', 'Ulasan berhasil dihapus.');
    }
}
