@extends('layouts.admin_full')

@section('title', 'Manajemen Produk')

@section('content')
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">Manajemen Produk</h2>

        <!-- Form Search dan Filter -->
        <form method="GET" class="flex flex-wrap gap-4 mb-4">
            <input type="text" name="q" placeholder="Cari nama produk..." value="{{ request('q') }}"
                class="border px-3 py-2 rounded text-sm w-64">

            <select name="kategori" class="border px-3 py-2 rounded text-sm w-48">
                <option value="">Semua Kategori</option>
                @foreach (['Arabika', 'Robusta', 'Liberika', 'Blend'] as $kat)
                    <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>
                        {{ $kat }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                Filter
            </button>
        </form>

        <!-- Tombol Tambah Produk -->
        <button
            onclick="document.getElementById('modalTambah').classList.remove('hidden'); document.getElementById('modalTambah').classList.add('flex')"
            class="bg-green-600 text-white px-4 py-2 rounded mb-4">
            Tambah Produk
        </button>

        <!-- Modal Tambah Produk -->
        <div id="modalTambah" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white p-6 rounded shadow-lg w-full max-w-xl">
                <h2 class="text-lg font-bold mb-4">Tambah Produk</h2>
                <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        <input type="text" name="nama" placeholder="Nama Produk" required class="border px-3 py-2 rounded">
                        <textarea name="deskripsi" placeholder="Deskripsi" class="border px-3 py-2 rounded"></textarea>
                        <input type="text" name="asal" placeholder="Asal" class="border px-3 py-2 rounded">
                        <input type="text" name="profil_rasa" placeholder="Profil Rasa" class="border px-3 py-2 rounded">
                        <input type="text" name="catatan_seduh" placeholder="Catatan Seduh"
                            class="border px-3 py-2 rounded">
                        <input type="number" name="harga" placeholder="Harga (dalam Rupiah)" required
                            class="border px-3 py-2 rounded">
                        <input type="number" name="stok" placeholder="Stok (dalam gram)" required
                            class="border px-3 py-2 rounded">
                        <select name="kategori" required class="border px-3 py-2 rounded">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach (['Arabika', 'Robusta', 'Liberika', 'Blend'] as $kat)
                                <option value="{{ $kat }}">{{ $kat }}</option>
                            @endforeach
                        </select>
                        <input type="file" name="url_gambar" accept="image/*" class="border px-3 py-2 rounded">
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-400 text-white rounded mr-2">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Produk -->
        <table class="w-full mt-6 border text-center">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2">ID</th>
                    <th class="p-2">Nama</th>
                    <th class="p-2">Kategori</th>
                    <th class="p-2">Harga (/50g)</th>
                    <th class="p-2">Stok (Kg)</th>
                    <th class="p-2">Gambar</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produk as $item)
                    <tr class="border-t">
                        <td class="p-2">{{ $item->kopi_id }}</td>
                        <td class="p-2">{{ $item->nama }}</td>
                        <td class="p-2">{{ $item->kategori }}</td>
                        <td class="p-2">Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="p-2">{{ number_format($item->stok / 1000, 2) }} Kg</td>
                        <td class="p-2">
                            @if ($item->url_gambar)
                                <img src="{{ asset('storage/' . $item->url_gambar) }}" alt="Gambar"
                                    class="w-48 h-48 object-cover rounded mx-auto">
                            @else
                                <span class="text-gray-500">Tidak ada</span>
                            @endif
                        </td>
                        <td class="p-2 space-x-2">
                            <a href="{{ route('admin.produk.edit', $item->kopi_id) }}"
                                class="inline-block px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                Edit
                            </a>
                            <form action="{{ route('admin.produk.destroy', $item->kopi_id) }}" method="POST"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin ingin menghapus produk ini?')"
                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                    Hapus
                                </button>
                            </form>
                            <a href="{{ route('admin.promo.showByKopi', $item->kopi_id) }}"
                                class="inline-block px-3 py-1 bg-purple-600 text-white rounded hover:bg-purple-700 transition">
                                🎁 Promo
                            </a>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-4">Tidak ada produk ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection