@extends('layouts.admin_full')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-6">Dashboard Admin</h2>

    {{-- Ringkasan --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="p-4 bg-white rounded shadow text-center">
            <div class="text-gray-500">Total Produk</div>
            <div class="text-3xl font-bold">{{ $totalProduk }}</div>
        </div>
        <div class="p-4 bg-white rounded shadow text-center">
            <div class="text-gray-500">Total Stok</div>
            <div class="text-3xl font-bold">{{ number_format($totalStok / 1000, 2, ',', '.') }} kg</div>
        </div>
        <div class="p-4 bg-white rounded shadow text-center">
            <div class="text-gray-500">Total Penjualan</div>
            <div class="text-3xl font-bold">Rp{{ number_format($totalPenjualan, 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- Grafik Pendapatan --}}
    <div class="bg-white p-6 rounded shadow mb-8">
        <form method="GET" class="mb-4 flex gap-2 items-center">
            <label for="pendapatan_tahun" class="text-sm font-medium">Tahun:</label>
            <select name="tahun" id="pendapatan_tahun" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">
                @foreach($tahunList as $t)
                    <option value="{{ $t }}" {{ $t == $tahunTerpilih ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
        </form>
        <h4 class="text-lg font-bold mb-2">Grafik Pendapatan Per Bulan ({{ $tahunTerpilih }})</h4>
        <canvas id="grafikPendapatan" height="100"></canvas>
    </div>

    {{-- Grafik Produk Terlaris --}}
    <div class="bg-white p-6 rounded shadow mb-8">
        <form method="GET" class="mb-4 flex gap-2 items-center">
            <label for="tahun_produk" class="text-sm font-medium">Tahun:</label>
            <select name="tahun_produk" id="tahun_produk" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">
                @foreach($tahunList as $t)
                    <option value="{{ $t }}" {{ $t == $tahunProduk ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>

            <label for="bulan_produk" class="text-sm font-medium">Bulan:</label>
            <select name="bulan_produk" id="bulan_produk" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">
                @foreach($bulanList as $key => $namaBulan)
                    <option value="{{ $key + 1 }}" {{ ($key + 1) == $bulanProduk ? 'selected' : '' }}>{{ $namaBulan }}</option>
                @endforeach
            </select>
        </form>
        <h4 class="text-lg font-bold mb-2">Produk Terlaris - {{ $bulanList[$bulanProduk - 1] }} {{ $tahunProduk }}</h4>
        <canvas id="grafikProdukTerlaris" height="100"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxPendapatan = document.getElementById('grafikPendapatan').getContext('2d');
    new Chart(ctxPendapatan, {
        type: 'bar',
        data: {
            labels: {!! json_encode($bulanList) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($pendapatanPerBulan) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    const ctxTerlaris = document.getElementById('grafikProdukTerlaris').getContext('2d');
    new Chart(ctxTerlaris, {
        type: 'bar',
        data: {
            labels: {!! json_encode($produkTerlaris->pluck('nama')) !!},
            datasets: [{
                label: 'Jumlah Terjual',
                data: {!! json_encode($produkTerlaris->pluck('total_terjual')) !!},
                backgroundColor: 'rgba(255, 159, 64, 0.6)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                x: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
