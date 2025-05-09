@extends('layouts.admin_full')

@section('title', 'Promo Produk')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">🎉 Promo untuk: <span class="text-blue-700">{{ $kopi->nama }}</span></h2>

        <button onclick="document.getElementById('modalTambahPromo').classList.remove('hidden')" 
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
            ➕ Tambah Promo
        </button>
    </div>

    <div class="bg-white rounded shadow p-5 max-w-2xl">
        <table class="table-auto w-full text-sm border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2 border">Diskon (%)</th>
                    <th class="px-4 py-2 border">Tanggal Mulai</th>
                    <th class="px-4 py-2 border">Tanggal Berakhir</th>
                    <th class="px-4 py-2 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($promo)
                    <tr>
                        <td class="px-4 py-2 border">{{ $promo->diskon_persen }}%</td>
                        <td class="px-4 py-2 border">{{ date('d M Y', strtotime($promo->tanggal_mulai)) }}</td>
                        <td class="px-4 py-2 border">{{ date('d M Y', strtotime($promo->tanggal_berakhir)) }}</td>
                        <td class="px-4 py-2 border text-center">
                            <a href="{{ route('admin.promo.edit', $promo->promo_id) }}"
                               class="inline-block px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('admin.promo.destroy', $promo->promo_id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin ingin menghapus promo ini?')"
                                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition mt-1">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">Belum ada promo untuk produk ini.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Promo -->
<div id="modalTambahPromo" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-lg">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">Tambah Promo untuk <span class="text-blue-600">{{ $kopi->nama }}</span></h2>
            <button onclick="document.getElementById('modalTambahPromo').classList.add('hidden')" class="text-gray-500 text-xl">&times;</button>
        </div>
        <form action="{{ route('admin.promo.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kopi_id" value="{{ $kopi->kopi_id }}">

            <div class="grid gap-4">
                <div>
                    <label class="block font-semibold mb-1">Diskon (%)</label>
                    <input type="number" name="diskon_persen" min="0" max="100" required class="border px-3 py-2 rounded w-full">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" required class="border px-3 py-2 rounded w-full">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Tanggal Berakhir</label>
                    <input type="date" name="tanggal_berakhir" required class="border px-3 py-2 rounded w-full">
                </div>
            </div>

            <div class="mt-5 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modalTambahPromo').classList.add('hidden')" 
                        class="px-4 py-2 bg-gray-400 text-white rounded">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Simpan Promo
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
