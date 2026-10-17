<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Pengaduan - FixIt</title>
    <style>
        body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f5f9; color: #334155; }
        .page-shell { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
        .card { background: white; padding: 30px; border-radius: 14px; box-shadow: 0 4px 15px rgba(15, 23, 42, 0.06); border: 1px solid #e2e8f0; }
        .card-header { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 20px; }
        .card h3 { margin: 0; color: #0f172a; font-size: 20px; }
        .btn-primary { display: inline-block; background-color: #1e3a8a; color: white; border: none; text-decoration: none; padding: 10px 18px; border-radius: 8px; font-size: 14px; font-weight: 700; }
        .btn-primary:hover { background-color: #172554; }
        .alert-success { background-color: #dcfce7; color: #166534; padding: 12px 14px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px 14px; border-bottom: 1px solid #e2e8f0; font-size: 14px; text-align: left; vertical-align: top; }
        th { background-color: #f8fafc; color: #475569; font-weight: 700; }
        tr:hover { background-color: #f8fafc; }
        .status-badge { display: inline-block; padding: 5px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-diproses { background-color: #dbeafe; color: #1d4ed8; }
        .status-selesai { background-color: #dcfce7; color: #166534; }
        .btn-detail { display: inline-block; padding: 7px 10px; border-radius: 6px; background-color: #e0e7ff; color: #1e3a8a; text-decoration: none; font-size: 12px; font-weight: 700; }
        .btn-detail:hover { background-color: #c7d2fe; }
        .empty-state { padding: 28px 16px; text-align: center; color: #64748b; }
        .thumb { width: 72px; height: 72px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0; }
        .link-muted { color: #1e3a8a; text-decoration: none; }
        .link-muted:hover { text-decoration: underline; }
        @media (max-width: 768px) { .card { padding: 20px 14px; } .card-header { flex-direction: column; align-items: flex-start; } table { display: block; overflow-x: auto; white-space: nowrap; } }
    </style>
</head>
<body>
    @include('layouts.navigation')

    <div class="page-shell">
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3>Riwayat Pengaduan</h3>
                <a href="{{ route('pengaduan.create') }}" class="btn-primary">Buat Pengaduan Baru</a>
            </div>

            @if ($pengaduans->isEmpty())
                <div class="empty-state">
                    <p>Belum ada laporan yang kamu kirim.</p>
                    <a href="{{ route('pengaduan.create') }}" class="btn-primary">Buat Pengaduan</a>
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Laporan</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Tanggal</th>
                            <th>Foto</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengaduans as $index => $pengaduan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $pengaduan->judul_laporan }}</strong></td>
                                <td>{{ $pengaduan->kategori->nama_kategori ?? '-' }}</td>
                                <td>{{ $pengaduan->lokasi }}</td>
                                <td>{{ \Carbon\Carbon::parse($pengaduan->created_at)->translatedFormat('d M Y') }}</td>
                                <td>
                                    @if ($pengaduan->foto)
                                        <img src="{{ Storage::url($pengaduan->foto) }}" alt="Foto kerusakan" class="thumb">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($pengaduan->status) {
                                            'Pending' => 'status-pending',
                                            'Diproses' => 'status-diproses',
                                            'Selesai' => 'status-selesai',
                                            default => 'status-pending',
                                        };
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">{{ $pengaduan->status }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('pengaduan.show', $pengaduan->id) }}" class="btn-detail">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    @include('layouts.footer')
</body>
</html>
