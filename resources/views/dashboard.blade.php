<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - FixIt</title>
    <!-- Menggunakan CDN Tailwind agar aman dari error Vite -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-blue-900 text-white p-4 shadow-md flex justify-between items-center px-8">
        <h1 class="text-xl font-bold">FixIt - Dashboard</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-600 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-700 transition">
                Logout
            </button>
        </form>
    </nav>

    <!-- Konten Utama Dashboard -->
    <div class="max-w-4xl mx-auto mt-10 p-8 bg-white rounded-xl shadow-lg border border-slate-200">
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
            Akun berhasil dibuat! Selamat datang di sistem pelaporan FixIt.
        </div>

        <h2 class="text-2xl font-bold text-slate-800 mb-2">Halo, {{ Auth::user()->name }}!</h2>
        <p class="text-slate-600 mb-4">
            Kamu login menggunakan email: <span class="font-semibold text-slate-800">{{ Auth::user()->email }}</span>
        </p>
        
        <div class="border-t border-slate-200 pt-4 mt-4">
            <p class="text-sm text-slate-500">
                Status Akun: <span class="font-semibold text-blue-600 uppercase">{{ Auth::user()->role ?? 'Mahasiswa' }}</span>
            </p>
        </div>
    </div>

</body>
</html>