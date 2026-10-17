<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - FixIt</title>
    <!-- Menggunakan CDN Tailwind agar aman dari error Vite -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    @include('layouts.navigation')

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

            @if (Auth::user()->role === 'admin')
                <div class="mt-6 pt-6 border-t border-slate-200">
                    <h3 class="text-base font-bold text-slate-800 mb-3">Menu Khusus Admin:</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('admin.laporan.index') }}" class="p-4 bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-100/80 transition flex items-center justify-between group">
                            <div>
                                <div class="font-bold text-blue-900 group-hover:underline">Kelola Laporan Masuk</div>
                                <div class="text-xs text-blue-700 mt-1">Pantau & ubah status laporan kerusakan mahasiswa</div>
                            </div>
                            <span class="text-blue-900 font-bold text-lg">&rarr;</span>
                        </a>

                        <a href="{{ route('kategori.index') }}" class="p-4 bg-slate-50 border border-slate-200 rounded-xl hover:bg-slate-100 transition flex items-center justify-between group">
                            <div>
                                <div class="font-bold text-slate-900 group-hover:underline">Kelola Kategori</div>
                                <div class="text-xs text-slate-600 mt-1">Tambah, edit, dan hapus kategori fasilitas</div>
                            </div>
                            <span class="text-slate-900 font-bold text-lg">&rarr;</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    @include('layouts.footer')

</body>
</html>