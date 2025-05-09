<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script> {{-- Atau Bootstrap --}}
</head>
<body class="bg-gray-100 text-gray-800">

    <nav class="bg-white p-4 shadow mb-6">
        <div class="text-xl font-bold">Panel Admin</div>
    </nav>

    <main class="px-6">
        @yield('content')
    </main>

</body>
</html>