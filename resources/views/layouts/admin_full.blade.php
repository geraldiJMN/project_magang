<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script> {{-- Feather Icons --}}
</head>
<body class="bg-[#f9f5f0] text-[#3e2f1c]">

<!-- Navbar Horizontal (Atas) -->
<nav class="bg-white shadow p-4 flex justify-between items-center relative">
    <div class="text-xl font-bold">☕ Admin Kopi</div>
    <div class="space-x-4 flex items-center">

        {{-- Notifikasi Dropdown --}}
        <div class="relative group">
            <button class="relative hover:text-[#4e342e]">
                <i data-feather="bell" class="w-5 h-5"></i>
                <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full px-1">3</span>
            </button>

            <div class="absolute right-0 mt-2 w-72 bg-white border rounded shadow-lg opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto transition duration-200 z-50">
                <div class="p-4 text-sm font-semibold text-gray-800 border-b">Notifikasi</div>
                <ul class="divide-y text-sm max-h-60 overflow-y-auto">
                    <li class="p-3 hover:bg-gray-100">Pesanan #1021 telah dibayar</li>
                    <li class="p-3 hover:bg-gray-100">Stok Kopi Toraja hampir habis</li>
                    <li class="p-3 hover:bg-gray-100">Pesanan baru masuk</li>
                </ul>
                <div class="text-center p-2 border-t">
                    <a href="{{ route('admin.notifikasi') }}" class="text-blue-600 text-sm hover:underline">Lihat semua</a>
                </div>
            </div>
        </div>

    </div>
</nav>

<div class="flex h-screen">
    <!-- Sidebar Kiri -->
    <aside class="w-64 bg-[#4e342e] text-white flex flex-col py-6 px-4">
        <nav class="space-y-3 text-sm">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 py-2 px-3 rounded hover:bg-[#6d4c41]">
                <i data-feather="home" class="w-4 h-4"></i> Dashboard
            </a>
            <a href="{{ route('admin.pengguna.index') }}" class="flex items-center gap-2 py-2 px-3 rounded hover:bg-[#6d4c41]">
                <i data-feather="users" class="w-4 h-4"></i> Pengguna
            </a>
            <a href="{{ route('admin.pesanan.index') }}" class="flex items-center gap-2 py-2 px-3 rounded hover:bg-[#6d4c41]">
                <i data-feather="shopping-cart" class="w-4 h-4"></i> Pesanan
            </a>
            <a href="{{ route('admin.produk.index') }}" class="flex items-center gap-2 py-2 px-3 rounded hover:bg-[#6d4c41]">
                <i data-feather="box" class="w-4 h-4"></i> Produk
            </a>
            <a href="{{ route('admin.ulasan.index') }}" class="flex items-center gap-2 py-2 px-3 rounded hover:bg-[#6d4c41]">
                <i data-feather="star" class="w-4 h-4"></i> Ulasan
            </a>
        </nav>
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 p-6 overflow-y-auto">
        @yield('content')
    </main>
</div>

<script>
    feather.replace(); // Aktifkan ikon Feather
</script>

{{-- Agar JavaScript dari child view (@push) bisa masuk --}}
@stack('scripts')

</body>
</html>
