<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduans = Pengaduan::with('kategori')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pengaduan.index', compact('pengaduans'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get()->unique('nama_kategori');

        return view('pengaduan.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'judul_laporan' => ['required', 'string', 'max:255'],
            'lokasi' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'kategori_id.required' => 'Kategori kerusakan wajib dipilih.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'judul_laporan.required' => 'Judul laporan wajib diisi.',
            'judul_laporan.max' => 'Judul laporan maksimal 255 karakter.',
            'lokasi.required' => 'Lokasi kerusakan wajib diisi.',
            'lokasi.max' => 'Lokasi maksimal 255 karakter.',
            'deskripsi.required' => 'Deskripsi kerusakan wajib diisi.',
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.mimes' => 'Format foto harus JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pengaduan', 'public');
        }

        Pengaduan::create([
            'user_id' => Auth::id(),
            'kategori_id' => $validated['kategori_id'],
            'judul_laporan' => $validated['judul_laporan'],
            'lokasi' => $validated['lokasi'],
            'deskripsi' => $validated['deskripsi'],
            'foto' => $fotoPath,
            'status' => 'Pending',
        ]);

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dikirim. Laporan Anda akan segera ditinjau.');
    }

    public function show($id)
    {
        $pengaduan = Pengaduan::with(['kategori', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('pengaduan.show', compact('pengaduan'));
    }
}
