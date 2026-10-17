<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Kategori - FixIt</title>
    <style>
        body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f5f9; color: #334155; }
        .navbar { background-color: #1e3a8a; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .navbar h1 { margin: 0; font-size: 18px; font-weight: bold; }
        .navbar a { color: white; text-decoration: none; font-size: 14px; font-weight: 500; }
        .navbar a:hover { text-decoration: underline; }
        .container { max-width: 950px; margin: 40px auto; padding: 0 20px; }
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; margin-bottom: 25px; }
        .card h3 { margin-top: 0; margin-bottom: 20px; color: #1e293b; font-size: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 6px; font-size: 14px; font-weight: 600; }
        .form-control { width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; font-size: 14px; outline: none; }
        .form-control:focus { border-color: #1e3a8a; box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1); }
        .btn-submit { background-color: #1e3a8a; color: white; border: none; padding: 10px 20px; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; }
        .btn-submit:hover { background-color: #172554; }
        .btn-warning { background-color: #d97706; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 600; }
        .btn-warning:hover { background-color: #b45309; }
        .btn-danger { background-color: #dc2626; color: white; padding: 6px 12px; border-radius: 4px; border: none; cursor: pointer; font-size: 12px; font-weight: 600; }
        .btn-danger:hover { background-color: #b91c1c; }
        .btn-secondary { background-color: #64748b; color: white; padding: 10px 15px; border-radius: 6px; text-decoration: none; font-size: 14px; margin-left: 10px; display: inline-block; }
        .btn-secondary:hover { background-color: #475569; }
        .alert-success { background-color: #dcfce7; color: #166534; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #e2e8f0; font-size: 14px; }
        th { background-color: #f8fafc; color: #475569; font-weight: 600; }
        tr:hover { background-color: #f8fafc; }
        .badge-role { background-color: #3b82f6; padding: 3px 10px; border-radius: 20px; font-size: 12px; text-transform: uppercase; font-weight: bold; margin-right: 15px; }
    </style>
</head>
<body>

    <!-- Navbar Sederhana -->
    @include('layouts.navigation')

    <div class="container">

        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Tambah / Edit Kategori -->
        <div class="card">
            <h3>{{ isset($kategori) ? 'Edit Kategori Kerusakan' : 'Tambah Kategori Baru' }}</h3>
            
            <form action="{{ isset($kategori) ? route('kategori.update', $kategori->id) : route('kategori.store') }}" method="POST">
                @csrf
                @if(isset($kategori))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="nama_kategori">Nama Kategori</label>
                    <input type="text" id="nama_kategori" name="nama_kategori" class="form-control" value="{{ $kategori->nama_kategori ?? old('nama_kategori') }}" required autocomplete="off" placeholder="Contoh: Fasilitas Kelas, Laboratorium">
                </div>
                
                <div class="form-group">
                    <label for="deskripsi">Deskripsi (Opsional)</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3" placeholder="Keterangan singkat kategori...">{{ $kategori->deskripsi ?? old('deskripsi') }}</textarea>
                </div>

                <button type="submit" class="btn-submit">{{ isset($kategori) ? 'Perbarui Kategori' : 'Simpan Kategori' }}</button>
                
                @if(isset($kategori))
                    <a href="{{ route('kategori.index') }}" class="btn-secondary">Batal</a>
                @endif
            </form>
        </div>

        <!-- Tabel Daftar Kategori -->
        <div class="card">
            <h3>Daftar Kategori Kerusakan</h3>
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th style="width: 150px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategoris as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $item->nama_kategori }}</strong></td>
                            <td>{{ $item->deskripsi ?? '-' }}</td>
                            <td style="text-align: center;">
                                <a href="{{ route('kategori.edit', $item->id) }}" class="btn-warning">Edit</a>
                                
                                <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: #94a3b8; padding: 20px;">Belum ada kategori yang ditambahkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- Footer -->
    @include('layouts.footer')

</body>
</html>