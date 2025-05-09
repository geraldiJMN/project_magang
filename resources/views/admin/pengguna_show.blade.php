@extends('layouts.admin_full')

@section('title', 'Riwayat Pengguna')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Detail Pengguna</h2>
    <div class="mb-6">
        <p><strong>ID:</strong> {{ $pengguna->pengguna_id }}</p>
        <p><strong>Nama:</strong> {{ $pengguna->nama }}</p>
        <p><strong>Email:</strong> {{ $pengguna->email }}</p>
    </div>

    <h3 class="text-xl font-semibold mb-3">Riwayat Pesanan</h3>
    <table class="w-full border">
        <thead class="bg-gray-200 text-center">
            <tr>
                <th class="p-2">ID Pesanan</th>
                <th class="p-2">Status</th>
                <th class="p-2">Total</th>
                <th class="p-2">Tanggal</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($riwayatPesanan as $pesanan)
            <tr class="text-center border-t">
                <td class="p-2">{{ $pesanan->pesanan_id }}</td>
                <td class="p-2">{{ $pesanan->status }}</td>
                <td class="p-2">Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                <td class="p-2">{{ $pesanan->dibuat_pada }}</td>
                <td class="p-2">
                    <button onclick="showModal({{ $pesanan->toJson() }})"
                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Lihat Detail
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-gray-500 py-4">Belum ada pesanan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Tombol Back --}}
    <div class="mt-6">
        <a href="{{ route('admin.pengguna.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Back
        </a>
    </div>
</div>

<!-- Modal -->
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-xl p-6 relative">
        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">🧾 Detail Pesanan</h2>
        <div class="grid grid-cols-1 gap-y-3 text-sm text-gray-700">
            <div class="flex justify-between"><span><strong>ID Pesanan:</strong></span><span id="modalIdPesanan"></span></div>
            <div class="flex justify-between"><span><strong>ID Pengguna:</strong></span><span id="modalIdPengguna"></span></div>
            <div class="flex justify-between"><span><strong>Status:</strong></span><span id="modalStatus"></span></div>
            <div class="flex justify-between"><span><strong>Metode Pembayaran:</strong></span><span id="modalPembayaran"></span></div>
            <div class="flex justify-between"><span><strong>Bukti Pembayaran:</strong></span><span id="modalBukti"></span></div>
            <div class="flex justify-between"><span><strong>No Resi:</strong></span><span id="modalResi"></span></div>
            <div class="flex justify-between"><span><strong>Total Harga:</strong></span><span id="modalTotal"></span></div>
            <div class="flex justify-between"><span><strong>Tanggal:</strong></span><span id="modalTanggal"></span></div>
        </div>
        <div class="text-right mt-6">
            <button onclick="document.getElementById('detailModal').classList.add('hidden')"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition">
                <i data-feather="x" class="w-4 h-4"></i> Tutup
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showModal(data) {
    document.getElementById('modalIdPesanan').textContent = data.pesanan_id || '-';
    document.getElementById('modalIdPengguna').textContent = data.pengguna_id || '-';
    document.getElementById('modalStatus').textContent = data.status || '-';
    document.getElementById('modalPembayaran').textContent = data.metode_pembayaran || '-';
    document.getElementById('modalBukti').textContent = data.bukti_pembayaran || '-';
    document.getElementById('modalResi').textContent = data.no_resi || '-';
    document.getElementById('modalTotal').textContent = 'Rp' + Number(data.total_harga).toLocaleString('id-ID');
    document.getElementById('modalTanggal').textContent = data.dibuat_pada || '-';

    const modal = document.getElementById('detailModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
</script>
@endpush
@endsection
