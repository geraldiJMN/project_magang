@extends('layouts.admin_full')

@section('title', 'Edit Produk')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Edit Produk</h2>

    <form method="POST" action="{{ route('admin.produk.update', $produk->kopi_id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-4 max-w-xl">
            <input type="text" name="nama" value="{{ old('nama', $produk->nama) }}" placeholder="Nama Produk" required class="border px-3 py-2 rounded">
            <textarea name="deskripsi" placeholder="Deskripsi" class="border px-3 py-2 rounded">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
            <input type="text" name="asal" value="{{ old('asal', $produk->asal) }}" placeholder="Asal" class="border px-3 py-2 rounded">
            <input type="text" name="profil_rasa" value="{{ old('profil_rasa', $produk->profil_rasa) }}" placeholder="Profil Rasa" class="border px-3 py-2 rounded">
            <input type="text" name="catatan_seduh" value="{{ old('catatan_seduh', $produk->catatan_seduh) }}" placeholder="Catatan Seduh" class="border px-3 py-2 rounded">
            <input type="number" name="harga" value="{{ old('harga', $produk->harga) }}" placeholder="Harga" required class="border px-3 py-2 rounded">
            <input type="number" name="stok" value="{{ old('stok', $produk->stok) }}" placeholder="Stok (gram)" required class="border px-3 py-2 rounded">
            
            <select name="kategori" required class="border px-3 py-2 rounded">
                <option value="">-- Pilih Kategori --</option>
                @foreach (['Arabika', 'Robusta', 'Liberika', 'Blend'] as $kategori)
                    <option value="{{ $kategori }}" @if ($produk->kategori == $kategori) selected @endif>{{ $kategori }}</option>
                @endforeach
            </select>

            <input type="file" name="url_gambar" accept="image/*" class="border px-3 py-2 rounded">

            @if ($produk->url_gambar)
                <img src="{{ asset('storage/' . $produk->url_gambar) }}" alt="Gambar" class="w-24 h-24 mt-2 object-cover rounded">
            @endif
        </div>

        <div class="mt-6 flex gap-4">
            <a href="{{ route('admin.produk.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
        </div>
    </form>
</div>
@endsection
