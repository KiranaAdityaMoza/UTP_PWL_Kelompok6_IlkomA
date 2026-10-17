<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pengaduan - FixIt</title>
    <style>
        body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f5f9; color: #334155; }
        .page-shell { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        .card { background: white; padding: 30px; border-radius: 14px; box-shadow: 0 4px 15px rgba(15, 23, 42, 0.06); border: 1px solid #e2e8f0; }
        .card h3 { margin: 0 0 24px; color: #0f172a; font-size: 22px; }
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        .detail-item { padding: 16px; border: 1px solid #e2e8f0; border-radius: 10px; background: #f8fafc; }
        .label { display: block; color: #475569; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; margin-bottom: 6px; }
        .value { color: #0f172a; font-size: 15px; line-height: 1.5; }
        .status-badge { display: inline-block; padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; text-transform: uppercase; }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-diproses { background-color: #dbeafe; color: #1d4ed8; }
        .status-selesai { background-color: #dcfce7; color: #166534; }
        .photo-box { margin-top: 20px; }
        .photo-box img { width: 100%; max-height: 320px; object-fit: cover; border-radius: 10px; border: 1px solid #e2e8f0; }
        .btn-primary { display: inline-block; margin-top: 24px; background-color: #1e3a8a; color: white; text-decoration: none; padding: 11px 18px; border-radius: 8px; font-size: 14px; font-weight: 700; }
        .btn-primary:hover { background-color: #172554; }
        @media (max-width: 768px) { .detail-grid { grid-template-columns: 1fr; } .card { padding: 20px 16px; } }
    </style>
</head>
<body>
    @include('layouts.navigation')

    <div class="page-shell">
        <div class="card">
            <h3>Detail Pengaduan</h3>

            <div class="detail-grid">
                <div class="detail-item">
                    <span class="label">Judul Laporan</span>
                    <div class="value">{{ $pengaduan->judul_laporan }}</div>
                </div>
                <div class="detail-item">
                    <span class="label">Status</span>
                    @php
                        $statusClass = match($pengaduan->status) {
                            'Pending' => 'status-pending',
                            'Diproses' => 'status-diproses',
                            'Selesai' => 'status-selesai',
                            default => 'status-pending',
                        };
                    @endphp
                    <span class="status-badge {{ $statusClass }}">{{ $pengaduan->status }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Kategori</span>
                    <div class="value">{{ $pengaduan->kategori->nama_kategori ?? '-' }}</div>
                </div>
                <div class="detail-item">
                    <span class="label">Lokasi</span>
                    <div class="value">{{ $pengaduan->lokasi }}</div>
                </div>
                <div class="detail-item" style="grid-column: 1 / -1;">
                    <span class="label">Deskripsi</span>
                    <div class="value">{{ $pengaduan->deskripsi }}</div>
                </div>
                <div class="detail-item">
                    <span class="label">Tanggal Laporan</span>
                    <div class="value">{{ \Carbon\Carbon::parse($pengaduan->created_at)->translatedFormat('d M Y, H:i') }}</div>
                </div>
                <div class="detail-item">
                    <span class="label">Pelapor</span>
                    <div class="value">{{ $pengaduan->user->name }}</div>
                </div>
            </div>

            @if ($pengaduan->foto)
                <div class="photo-box">
                    <img src="{{ Storage::url($pengaduan->foto) }}" alt="Foto kerusakan">
                </div>
            @endif

            <a href="{{ route('pengaduan.index') }}" class="btn-primary">Kembali ke Riwayat Pengaduan</a>
        </div>
    </div>

    @include('layouts.footer')
</body>
</html>
