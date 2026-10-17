<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Laporan Masuk - Panel Admin FixIt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif;}
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    @include('layouts.navigation')

    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!--header-->>
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                    <span>Kelola Laporan Masuk</span>
                    <span class="text-xs font-bold px-2.5 py-1 bg-blue-100 text-blue-800 rounded-full">Khusus Admin</span>
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Pantau dan perbarui status laporan kerusakan fasilitas kampus yang dikirimkan oleh seluruh mahasiswa.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.laporan.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold rounded-lg bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 shadow-sm transition">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Refresh Data
                </a>
            </div>
        </div>

        <!-- Flash Alert Notification -->
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 shadow-sm flex items-start justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold">Aksi Berhasil!</div>
                        <div class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</div>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm">
                <div class="text-sm font-bold mb-1">Terjadi Kesalahan:</div>
                <ul class="list-disc list-inside text-xs space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Rekapitulasi Statistik Cards (Overview Panel) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Total Laporan -->
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow transition">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Laporan</div>
                        <div class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalLaporan }}</div>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 text-xs text-slate-500">Rekapitulasi seluruh laporan mahasiswa</div>
            </div>

            <!-- Status Pending -->
            <div class="bg-white p-5 rounded-xl border border-amber-200 shadow-sm hover:shadow transition bg-gradient-to-br from-white to-amber-50/40">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-semibold text-amber-700 uppercase tracking-wider">Menunggu (Pending)</div>
                        <div class="text-3xl font-extrabold text-amber-800 mt-1">{{ $totalPending }}</div>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 flex items-center justify-between text-xs">
                    <span class="text-amber-700 font-medium">Perlu ditindaklanjuti</span>
                    <a href="{{ route('admin.laporan.index', ['status' => 'Pending']) }}" class="text-amber-800 font-semibold hover:underline">Filter &rarr;</a>
                </div>
            </div>

            <!-- Status Diproses -->
            <div class="bg-white p-5 rounded-xl border border-blue-200 shadow-sm hover:shadow transition bg-gradient-to-br from-white to-blue-50/40">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-semibold text-blue-700 uppercase tracking-wider">Sedang Diproses</div>
                        <div class="text-3xl font-extrabold text-blue-800 mt-1">{{ $totalDiproses }}</div>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 flex items-center justify-between text-xs">
                    <span class="text-blue-700 font-medium">Dalam perbaikan teknisi</span>
                    <a href="{{ route('admin.laporan.index', ['status' => 'Diproses']) }}" class="text-blue-800 font-semibold hover:underline">Filter &rarr;</a>
                </div>
            </div>

            <!-- Status Selesai -->
            <div class="bg-white p-5 rounded-xl border border-emerald-200 shadow-sm hover:shadow transition bg-gradient-to-br from-white to-emerald-50/40">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-semibold text-emerald-700 uppercase tracking-wider">Selesai Diperbaiki</div>
                        <div class="text-3xl font-extrabold text-emerald-800 mt-1">{{ $totalSelesai }}</div>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 flex items-center justify-between text-xs">
                    <span class="text-emerald-700 font-medium">Fasilitas telah diperbaiki</span>
                    <a href="{{ route('admin.laporan.index', ['status' => 'Selesai']) }}" class="text-emerald-800 font-semibold hover:underline">Filter &rarr;</a>
                </div>
            </div>
        </div>

        <!-- Filter & Search Toolbar Card -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm mb-6">
            <form action="{{ route('admin.laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                <!-- Search Input -->
                <div class="md:col-span-5">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Cari Laporan / Pelapor / Lokasi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Contoh: AC Bocor, Lab Komputer, Ahmad..." class="w-full pl-9 pr-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition">
                    </div>
                </div>

                <!-- Filter Status -->
                <div class="md:col-span-3">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Status Laporan</label>
                    <select name="status" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none bg-white transition">
                        <option value="">Semua Status</option>
                        <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                        <option value="Diproses" {{ request('status') === 'Diproses' ? 'selected' : '' }}>Diproses (Sedang Dikerjakan)</option>
                        <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai (Sudah Diperbaiki)</option>
                    </select>
                </div>

                <!-- Filter Kategori -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kategori</label>
                    <select name="kategori_id" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none bg-white transition">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="md:col-span-2 flex items-center gap-2">
                    <button type="submit" class="w-full bg-blue-900 hover:bg-blue-800 text-white font-semibold py-2 px-3 rounded-lg text-sm transition shadow-sm flex items-center justify-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'status', 'kategori_id']))
                        <a href="{{ route('admin.laporan.index') }}" title="Reset Filter" class="p-2 border border-slate-300 rounded-lg text-slate-600 hover:bg-slate-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabel Rekapitulasi Laporan Masuk -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-slate-50/70">
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-bold text-slate-800">Tabel Rekapitulasi Laporan Masuk</h2>
                    <span class="text-xs bg-slate-200 text-slate-700 px-2 py-0.5 rounded-full font-semibold">
                        {{ $laporans->total() }} Laporan
                    </span>
                </div>
                <div class="text-xs text-slate-500">
                    Alur Status: 
                    <span class="font-semibold text-amber-700">Pending</span> &rarr; 
                    <span class="font-semibold text-blue-700">Diproses</span> &rarr; 
                    <span class="font-semibold text-emerald-700">Selesai</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-100/80 text-slate-600 text-xs uppercase tracking-wider font-semibold border-b border-slate-200">
                            <th class="py-3 px-4 w-12 text-center">No</th>
                            <th class="py-3 px-4 min-w-[130px]">Tanggal</th>
                            <th class="py-3 px-4 min-w-[160px]">Pelapor (Mahasiswa)</th>
                            <th class="py-3 px-4 min-w-[140px]">Kategori</th>
                            <th class="py-3 px-4 min-w-[240px]">Judul, Lokasi & Deskripsi</th>
                            <th class="py-3 px-4 min-w-[100px] text-center">Foto</th>
                            <th class="py-3 px-4 min-w-[130px] text-center">Status</th>
                            <th class="py-3 px-4 min-w-[220px] text-center">Aksi Ubah Status Admin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($laporans as $index => $item)
                            <tr class="hover:bg-slate-50/90 transition duration-150">
                                <!-- No -->
                                <td class="py-4 px-4 text-center font-medium text-slate-500 text-xs">
                                    {{ $laporans->firstItem() + $index }}
                                </td>

                                <!-- Tanggal -->
                                <td class="py-4 px-4 text-xs text-slate-600">
                                    <div class="font-semibold text-slate-800">{{ $item->created_at->format('d M Y') }}</div>
                                    <div class="text-slate-400 mt-0.5">{{ $item->created_at->format('H:i') }} WIB</div>
                                    <div class="text-[10px] text-slate-400 mt-0.5">({{ $item->created_at->diffForHumans() }})</div>
                                </td>

                                <!-- Pelapor -->
                                <td class="py-4 px-4">
                                    <div class="font-bold text-slate-900 text-sm flex items-center gap-1.5">
                                        <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-extrabold flex-shrink-0">
                                            {{ strtoupper(substr($item->user->name ?? 'M', 0, 1)) }}
                                        </div>
                                        <span>{{ $item->user->name ?? 'Mahasiswa' }}</span>
                                    </div>
                                    <div class="text-xs text-slate-500 pl-7">{{ $item->user->email ?? '-' }}</div>
                                </td>

                                <!-- Kategori -->
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $item->kategori->nama_kategori ?? 'Umum' }}
                                    </span>
                                </td>

                                <!-- Judul, Lokasi & Deskripsi -->
                                <td class="py-4 px-4">
                                    <div class="font-semibold text-slate-900 leading-snug">
                                        {{ $item->judul_laporan }}
                                    </div>
                                    <div class="text-xs text-slate-500 flex items-center gap-1 mt-1">
                                        <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>{{ $item->lokasi }}</span>
                                    </div>

                                    <!-- Deskripsi Rinci Menggunakan Tag HTML5 Native (Bisa dibuka/tutup tanpa Javascript) -->
                                    <details class="mt-2 text-xs">
                                        <summary class="cursor-pointer text-blue-700 hover:text-blue-900 font-semibold select-none inline-flex items-center gap-1">
                                            <span>Lihat Deskripsi Lengkap</span>
                                            <span class="text-[10px]">&darr;</span>
                                        </summary>
                                        <div class="mt-1.5 p-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 whitespace-pre-line leading-relaxed">
                                            {{ $item->deskripsi }}
                                        </div>
                                    </details>
                                </td>

                                <!-- Bukti Foto -->
                                <td class="py-4 px-4 text-center">
                                    @if ($item->foto)
                                        <a href="{{ asset('storage/' . $item->foto) }}" target="_blank" title="Klik untuk membuka foto di tab baru" class="inline-block group text-center">
                                            <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Kerusakan" class="w-12 h-12 object-cover rounded-lg border border-slate-200 group-hover:opacity-80 transition shadow-sm mx-auto">
                                            <span class="block text-[11px] text-blue-700 font-medium group-hover:underline mt-1">Buka Foto &nearr;</span>
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Tidak ada foto</span>
                                    @endif
                                </td>

                                <!-- Status Badge -->
                                <td class="py-4 px-4 text-center">
                                    @if ($item->status === 'Pending')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-300 shadow-xs">
                                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                            Pending
                                        </span>
                                    @elseif ($item->status === 'Diproses')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-300 shadow-xs">
                                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                            Diproses
                                        </span>
                                    @elseif ($item->status === 'Selesai')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300 shadow-xs">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                            Selesai
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                            {{ $item->status }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Aksi Ubah Status Admin -->
                                <td class="py-4 px-4 text-center">
                                    <div class="flex flex-col gap-2 items-center justify-center">
                                        <!-- Form Ubah Status Langsung via Select -->
                                        <form action="{{ route('admin.laporan.update-status', $item->id) }}" method="POST" class="flex items-center gap-1.5">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="text-xs font-semibold py-1.5 px-2.5 border rounded-lg focus:ring-2 focus:ring-blue-600 outline-none transition
                                                {{ $item->status === 'Pending' ? 'border-amber-400 bg-amber-50/50 text-amber-900' : '' }}
                                                {{ $item->status === 'Diproses' ? 'border-blue-400 bg-blue-50/50 text-blue-900' : '' }}
                                                {{ $item->status === 'Selesai' ? 'border-emerald-400 bg-emerald-50/50 text-emerald-900' : '' }}">
                                                <option value="Pending" {{ $item->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="Diproses" {{ $item->status === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                                <option value="Selesai" {{ $item->status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>

                                            <button type="submit" title="Simpan Perubahan Status" class="bg-blue-900 hover:bg-blue-800 text-white p-1.5 rounded-lg text-xs font-semibold shadow-xs transition flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </form>

                                        <!-- Quick Action (Pending -> Diproses -> Selesai) -->
                                        <div class="flex items-center gap-1.5">
                                            @if ($item->status === 'Pending')
                                                <form action="{{ route('admin.laporan.update-status', $item->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="Diproses">
                                                    <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-semibold bg-blue-600 hover:bg-blue-700 text-white rounded shadow-xs transition">
                                                        <span>Mulai Proses</span> &rarr;
                                                    </button>
                                                </form>
                                            @elseif ($item->status === 'Diproses')
                                                <form action="{{ route('admin.laporan.update-status', $item->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="Selesai">
                                                    <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-semibold bg-emerald-600 hover:bg-emerald-700 text-white rounded shadow-xs transition">
                                                        <span>Tandai Selesai</span> &#10003;
                                                    </button>
                                                </form>
                                            @elseif ($item->status === 'Selesai')
                                                <span class="text-[11px] text-emerald-600 font-bold flex items-center gap-0.5">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                    Tuntas
                                                </span>
                                            @endif

                                            <!-- Tombol Hapus Laporan -->
                                            <form action="{{ route('admin.laporan.destroy', $item->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus Laporan" class="text-rose-500 hover:text-rose-700 hover:bg-rose-50 p-1 rounded transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mb-3 text-slate-400">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div class="font-bold text-slate-700 text-base">Belum Ada Laporan Masuk</div>
                                        <div class="text-xs text-slate-500 mt-1 max-w-sm">
                                            Tidak ada data laporan kerusakan fasilitas yang sesuai dengan filter pencarian Anda saat ini.
                                        </div>
                                        @if(request()->hasAny(['search', 'status', 'kategori_id']))
                                            <a href="{{ route('admin.laporan.index') }}" class="mt-4 inline-flex items-center px-4 py-2 text-xs font-semibold rounded-lg bg-blue-900 text-white hover:bg-blue-800 transition">
                                                Hapus Filter & Tampilkan Semua
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Page Footer -->
            @if ($laporans->hasPages())
                <div class="p-4 border-t border-slate-200 bg-slate-50">
                    {{ $laporans->links() }}
                </div>
            @endif
        </div>

    </main>

    <!-- Footer -->
    @include('layouts.footer')

</body>
</html>
