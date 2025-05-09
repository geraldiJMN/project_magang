@extends('layouts.admin_full')

@section('title', 'Manajemen Ulasan')

@php
    function tampilkanBintang($rating) {
        $output = '';
        $penuh = floor($rating);
        $setengah = ($rating - $penuh) >= 0.5 ? 1 : 0;
        $kosong = 5 - $penuh - $setengah;

        for ($i = 0; $i < $penuh; $i++) {
            $output .= '<svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 text-yellow-500 fill-current" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.431L24 9.748l-6 5.854L19.335 24 12 20.012 4.665 24 6 15.602 0 9.748l8.332-1.73z"/></svg>';
        }

        if ($setengah) {
            $output .= '<svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 text-yellow-500" viewBox="0 0 24 24">
                <defs>
                    <linearGradient id="half">
                        <stop offset="50%" stop-color="currentColor"/>
                        <stop offset="50%" stop-color="transparent"/>
                    </linearGradient>
                </defs>
                <path fill="url(#half)" d="M12 .587l3.668 7.431L24 9.748l-6 5.854L19.335 24 12 20.012 4.665 24 6 15.602 0 9.748l8.332-1.73z"/>
            </svg>';
        }

        for ($i = 0; $i < $kosong; $i++) {
            $output .= '<svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 text-gray-300 fill-current" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.431L24 9.748l-6 5.854L19.335 24 12 20.012 4.665 24 6 15.602 0 9.748l8.332-1.73z"/></svg>';
        }

        return $output;
    }
@endphp

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Daftar Ulasan</h2>

    <table class="w-full border mt-4">
        <thead class="bg-gray-200 text-center">
            <tr>
                <th class="p-2">ID</th>
                <th class="p-2">Pengguna</th>
                <th class="p-2">Kopi</th>
                <th class="p-2">Rating</th>
                <th class="p-2">Komentar</th>
                <th class="p-2">Komentar Terbaik</th>
                <th class="p-2">Tanggal</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ulasan as $item)
            <tr class="text-center border-t">
                <td class="p-2">{{ $item->ulasan_id }}</td>
                <td class="p-2">{{ $item->pengguna->nama ?? '-' }}</td>
                <td class="p-2">{{ $item->kopi->nama ?? '-' }}</td>
                <td class="p-2">
                    {{ $item->rating }}
                    {!! tampilkanBintang($item->rating) !!}
                </td>
                <td class="p-2">{{ $item->komentar }}</td>
                <td class="p-2">
                    <form action="{{ route('admin.ulasan.update', $item->ulasan_id) }}" method="POST" class="flex items-center justify-center gap-2">
                        @csrf
                        @method('PUT')
                        <select name="komentar_terbaik" class="border rounded px-2 py-1 text-sm">
                            <option value="ya" {{ $item->komentar_terbaik == 'ya' ? 'selected' : '' }}>Ya</option>
                            <option value="tidak" {{ $item->komentar_terbaik == 'tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        <button type="submit" class="bg-green-600 text-white text-xs px-2 py-1 rounded hover:bg-green-700 transition">
                            Simpan
                        </button>
                    </form>
                </td>
                <td class="p-2">{{ $item->dibuat_pada }}</td>
                <td class="p-2">
                    <form action="{{ route('admin.ulasan.destroy', $item->ulasan_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ulasan ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-gray-500 py-4">Belum ada ulasan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
