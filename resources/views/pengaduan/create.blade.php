<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buat Pengaduan - FixIt</title>
    <style>
        body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f5f9; color: #334155; }
        .page-shell { max-width: 780px; margin: 40px auto; padding: 0 20px; }
        .card { background: white; padding: 30px; border-radius: 14px; box-shadow: 0 4px 15px rgba(15, 23, 42, 0.06); border: 1px solid #e2e8f0; margin-bottom: 25px; }
        .card h3 { margin: 0 0 22px; color: #0f172a; font-size: 20px; }
        .alert-success { background-color: #dcfce7; color: #166534; padding: 12px 14px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
        .alert-error { background-color: #fef2f2; color: #991b1b; padding: 12px 14px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
        .alert-error ul { margin: 0; padding-left: 18px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 8px; font-size: 14px; font-weight: 700; color: #334155; }
        .form-control { width: 100%; padding: 11px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; box-sizing: border-box; color: #0f172a; background: #fff; }
        .form-control:focus { border-color: #1e3a8a; outline: none; box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.08); }
        textarea.form-control { min-height: 120px; resize: vertical; }
        .btn-primary { background-color: #1e3a8a; color: white; border: none; padding: 12px 22px; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; }
        .btn-primary:hover { background-color: #172554; }
        .btn-secondary { display: inline-block; margin-left: 10px; background-color: #64748b; color: white; text-decoration: none; padding: 11px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; }
        .btn-secondary:hover { background-color: #475569; }
        .error-message { color: #b91c1c; font-size: 12px; margin-top: 6px; }
        .is-invalid { border-color: #dc2626; }
    </style>
</head>
<body>
    @include('layouts.navigation')

    <div class="page-shell">
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <h3>Buat Pengaduan</h3>

            <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="kategori_id">Kategori Kerusakan</label>

                    @if ($kategoris->isEmpty())
                        <div class="alert-error" style="margin-top: 0; margin-bottom: 12px;">
                            Belum ada kategori kerusakan yang tersedia. Silakan tambah kategori dari halaman admin terlebih dahulu.
                        </div>
                        <select id="kategori_id" name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror" disabled required>
                            <option value="">Belum ada pilihan kategori</option>
                        </select>
                    @else
                        <select id="kategori_id" name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror" required>
                            <option value="">Pilih kategori kerusakan</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    @endif

                    @error('kategori_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="judul_laporan">Judul Laporan</label>
                    <input type="text" id="judul_laporan" name="judul_laporan" class="form-control @error('judul_laporan') is-invalid @enderror" value="{{ old('judul_laporan') }}" placeholder="Contoh: AC mati di ruang 101" required>
                    @error('judul_laporan')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="lokasi">Lokasi Kerusakan</label>
                    <input type="text" id="lokasi" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi') }}" placeholder="Contoh: Gedung A, Lt. 2" required>
                    @error('lokasi')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi Kerusakan</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Jelaskan kondisi kerusakan secara detail..." required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="foto">Foto Kerusakan (Opsional)</label>
                    <input type="file" id="foto" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                    @error('foto')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-primary" {{ $kategoris->isEmpty() ? 'disabled' : '' }} style="opacity: {{ $kategoris->isEmpty() ? '0.6' : '1' }}; cursor: {{ $kategoris->isEmpty() ? 'not-allowed' : 'pointer' }};">Kirim Pengaduan</button>
                <a href="{{ route('pengaduan.index') }}" 
            </form>
        </div>
    </div>

    @include('layouts.footer')
</body>
</html>
