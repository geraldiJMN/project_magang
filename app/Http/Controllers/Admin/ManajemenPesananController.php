<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\Storage;

class ManajemenPesananController extends Controller
{
    // Tampilkan semua pesanan
    public function index(Request $request)
    {
        $statusFilter = $request->input('status');
        $keyword = $request->input('q');

        $pesanan = Pesanan::with('pengguna')
            ->when($statusFilter, fn($query) => $query->where('status', $statusFilter))
            ->when(
                $keyword,
                fn($query) =>
                $query->whereHas(
                    'pengguna',
                    fn($q) =>
                    $q->where('nama', 'like', '%' . $keyword . '%')
                )
            )
            ->latest()
            ->get();

        return view('admin.pesanan', compact('pesanan', 'statusFilter', 'keyword'));
    }


    // Tampilkan detail dari satu pesanan
    public function show($id)
    {
        $pesanan = Pesanan::with(['pengguna', 'detailPesanan.varian.kopi'])->findOrFail($id);
        return view('admin.pesanan', compact('pesanan'));
    }

    // Update status pesanan (Belum Dibayar, Diproses, Dikirim, Selesai)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Belum Dibayar,Diproses,Dikirim,Selesai',
            'no_resi' => 'nullable|string|max:100'
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = $request->status;
        $pesanan->no_resi = $request->no_resi ?? $pesanan->no_resi;
        $pesanan->save();

        return redirect()->back()->with('success', 'Status pesanan diperbarui.');
    }

    // Opsional: hapus pesanan (jika diperbolehkan)
    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Jika ada bukti pembayaran, hapus filenya
        if ($pesanan->bukti_pembayaran && Storage::exists($pesanan->bukti_pembayaran)) {
            Storage::delete($pesanan->bukti_pembayaran);
        }

        $pesanan->delete();

        return redirect()->route('admin.pesanan')->with('success', 'Pesanan dihapus.');
    }
}
