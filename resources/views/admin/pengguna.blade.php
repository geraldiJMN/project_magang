@extends('layouts.admin_full')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Daftar Pengguna</h2>

    <!-- Form Search -->
    <form method="GET" action="{{ route('admin.pengguna.index') }}" class="mb-4">
        <input type="text" name="q" placeholder="Cari nama pengguna..." value="{{ request('q') }}"
               class="border px-3 py-2 rounded w-1/3 text-sm">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-sm">
            Cari
        </button>
    </form>

    <table class="w-full mt-4 border">
        <thead class="bg-gray-200 text-center">
            <tr>
                <th class="p-2">ID</th>
                <th class="p-2">Nama</th>
                <th class="p-2">Email</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengguna as $user)
            <tr class="text-center border-t">
                <td class="p-2">{{ $user->pengguna_id }}</td>
                <td class="p-2">{{ $user->nama }}</td>
                <td class="p-2">{{ $user->email }}</td>
                <td class="p-2">
                    <a href="{{ route('admin.pengguna.show', $user->pengguna_id) }}"
                       class="inline-block px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Lihat Riwayat
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-4 text-gray-500">Pengguna tidak ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
