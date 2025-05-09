<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Sidebar')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f9f5f0] text-[#3e2f1c]">

<div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-[#4e342e] text-white flex flex-col py-6 px-4">
        <h1 class="text-2xl font-bold mb-8 text-center">☕ Admin Kopi</h1>
        <nav class="space-y-3">
            <a href="{{ route('admin.dashboard') }}" class="block py-2 px-3 rounded hover:bg-[#6d4c41]">Dashboard</a>
            <a href="{{ route('admin.pengguna.index') }}" class="block py-2 px-3 rounded hover:bg-[#6d4c41]">Manajemen Pengguna</a>
            <a href="{{ route('admin.pesanan.index') }}" class="block py-2 px-3 rounded hover:bg-[#6d4c41]">Manajemen Pesanan</a>
            <a href="{{ route('admin.produk.index') }}" class="block py-2 px-3 rounded hover:bg-[#6d4c41]">Manajemen Produk</a>
            <a href="{{ route('admin.stok.index') }}" class="block py-2 px-3 rounded hover:bg-[#6d4c41]">Manajemen Stok</a>
            <a href="{{ route('admin.ulasan.index') }}" class="block py-2 px-3 rounded hover:bg-[#6d4c41]">Manajemen Ulasan</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">
        @yield('content')
    </main>
</div>

</body>
</html>
