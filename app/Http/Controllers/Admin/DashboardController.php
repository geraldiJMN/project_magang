<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Kopi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Tahun yang tersedia (diambil dari data pesanan)
        $tahunList = Pesanan::selectRaw('YEAR(dibuat_pada) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();

        // Default tahun saat ini jika tidak dipilih
        $tahunTerpilih = $request->input('tahun', date('Y'));
        $tahunProduk = $request->input('tahun_produk', date('Y'));
        $bulanProduk = $request->input('bulan_produk', date('n'));

        $bulanList = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Ringkasan
        $totalProduk = Kopi::count();
        $totalStok = Kopi::sum('stok');
        $totalPenjualan = Pesanan::where('status', 'Selesai')->sum('total_harga');
        
        // Grafik Pendapatan per Bulan (1–12)
        $pendapatanQuery = Pesanan::selectRaw('MONTH(dibuat_pada) as bulan, SUM(total_harga) as total')
            ->whereYear('dibuat_pada', $tahunTerpilih)
            ->where('status', 'Selesai')
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        // Isi array 12 bulan penuh, meskipun tidak ada data
        $pendapatanPerBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $pendapatanPerBulan[] = $pendapatanQuery[$i] ?? 0;
        }

        // Produk Terlaris untuk bulan & tahun tertentu
        $produkTerlaris = DB::table('detail_pesanan')
            ->join('varian_kopi', 'detail_pesanan.varian_id', '=', 'varian_kopi.varian_id')
            ->join('kopi', 'varian_kopi.kopi_id', '=', 'kopi.kopi_id')
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.pesanan_id')
            ->whereMonth('pesanan.dibuat_pada', $bulanProduk)
            ->whereYear('pesanan.dibuat_pada', $tahunProduk)
            ->where('pesanan.status', 'Selesai')
            ->select('kopi.nama', DB::raw('SUM(detail_pesanan.jumlah) as total_terjual'))
            ->groupBy('kopi.nama')
            ->orderByDesc('total_terjual')
            ->get();

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalStok',
            'totalPenjualan',
            'pendapatanPerBulan',
            'produkTerlaris',
            'tahunList',
            'tahunTerpilih',
            'tahunProduk',
            'bulanProduk',
            'bulanList'
        ));
    }
}
