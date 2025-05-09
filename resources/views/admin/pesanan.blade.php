@extends('layouts.admin_full')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Daftar Pesanan</h2>

    {{-- Form Search & Filter --}}
    <form method="GET" class="flex flex-wrap gap-4 mb-4">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama pengguna..."
            class="border px-3 py-2 rounded text-sm w-64">

        <select name="status" class="border px-3 py-2 rounded text-sm w-48">
            <option value="">Semua Status</option>
            @foreach(['Belum Dibayar', 'Diproses', 'Dikirim', 'Selesai'] as $status)
                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                    {{ $status }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-sm">
            Filter
        </button>
    </form>

    {{-- Tabel Pesanan --}}
    <table class="w-full border mt-2">
        <thead class="bg-gray-200 text-center">
            <tr>
                <th class="p-2">ID</th>
                <th class="p-2">Pengguna</th>
                <th class="p-2">Status</th>
                <th class="p-2">Metode Pembayaran</th>
                <th class="p-2">Total</th>
                <th class="p-2">Tanggal</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesanan as $item)
            <tr class="text-center border-t">
                <td class="p-2">{{ $item->pesanan_id }}</td>
                <td class="p-2">{{ $item->pengguna->nama ?? '-' }}</td>
                <td class="p-2">
                    <form action="{{ route('admin.pesanan.updateStatus', $item->pesanan_id) }}" method="POST" class="flex items-center justify-center gap-2">
                        @csrf
                        @method('PUT')
                        <select name="status" class="border rounded px-2 py-1 text-sm {{
                            $item->status == 'Belum Dibayar' ? 'bg-red-100 text-red-700' :
                            ($item->status == 'Diproses' ? 'bg-yellow-100 text-yellow-700' :
                            ($item->status == 'Dikirim' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700'))
                        }}">
                            @foreach (['Belum Dibayar', 'Diproses', 'Dikirim', 'Selesai'] as $status)
                                <option value="{{ $status }}" {{ $item->status == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-green-600 text-white text-xs px-2 py-1 rounded hover:bg-green-700 transition">
                            Simpan
                        </button>
                    </form>
                </td>
                <td class="p-2">{{ $item->metode_pembayaran ?? '-' }}</td>
                <td class="p-2">Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                <td class="p-2">{{ $item->dibuat_pada }}</td>
                <td class="p-2">
                    <button onclick='openDetailModal(@json($item))'
                        class="inline-block px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Detail
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-gray-500 py-4">Tidak ada pesanan ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Modal & Script tetap seperti sebelumnya --}}
<!-- Modal Detail -->
<div id="modalDetail" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-2xl">
        <h2 class="text-lg font-bold mb-4">Detail Pesanan</h2>
        <div id="detailContent" class="text-sm space-y-2">
            <!-- Konten akan diisi oleh JavaScript -->
        </div>
        <div class="flex justify-end mt-4">
            <button type="button" onclick="document.getElementById('modalDetail').classList.add('hidden')" class="px-4 py-2 bg-gray-400 text-white rounded">Tutup</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openDetailModal(data) {
        const modal = document.getElementById('modalDetail');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        const content = `
            <p><strong>ID Pesanan:</strong> ${data.pesanan_id}</p>
            <p><strong>ID Pengguna:</strong> ${data.pengguna_id}</p>
            <p><strong>Status:</strong> ${data.status}</p>
            <p><strong>Metode Pembayaran:</strong> ${data.metode_pembayaran || '-'}</p>
            <p><strong>No Resi:</strong> ${data.no_resi || '-'}</p>
            <p><strong>Total Harga:</strong> Rp${parseInt(data.total_harga).toLocaleString('id-ID')}</p>
            <p><strong>Tanggal:</strong> ${data.dibuat_pada}</p>
            <p><strong>Bukti Pembayaran:</strong><br>
                ${data.bukti_pembayaran 
                    ? `<img src='/storage/${data.bukti_pembayaran}' alt='Bukti' class='w-40 mt-2 rounded'>` 
                    : '<span class="text-gray-500">Tidak ada</span>'}
            </p>
        `;
        document.getElementById('detailContent').innerHTML = content;
    }
</script>
@endpush
@endsection
