<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // panel admin dan tabel rekapitulasi laporan masuk
    public function index(Request $request)
    {
        // Query laporan dengan relasi user (mahasiswa pelapor) dan kategori
        $query = Pengaduan::with(['user', 'kategori'])->latest();

        // Filter berdasarkan status jika dipilih
        if ($request->filled('status') && in_array($request->status, ['Pending', 'Diproses', 'Selesai'])) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan kategori jika dipilih
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Fitur pencarian berdasarkan judul, lokasi, atau nama mahasiswa
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul_laporan', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $laporans = $query->paginate(10)->withQueryString();

        // Data rekapitulasi statistik laporan
        $totalLaporan = Pengaduan::count();
        $totalPending = Pengaduan::where('status', 'Pending')->count();
        $totalDiproses = Pengaduan::where('status', 'Diproses')->count();
        $totalSelesai = Pengaduan::where('status', 'Selesai')->count();

        // Daftar kategori untuk filter
        $kategoris = Kategori::all();

        return view('admin.laporan.index', compact(
            'laporans',
            'kategoris',
            'totalLaporan',
            'totalPending',
            'totalDiproses',
            'totalSelesai'
        ));
    }

    // Memperbarui status laporan pengaduan
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Diproses,Selesai',
        ], [
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus berupa Pending, Diproses, atau Selesai.',
        ]);

        $laporan = Pengaduan::findOrFail($id);
        $statusLama = $laporan->status;
        $laporan->status = $request->status;
        $laporan->save();

        return redirect()->back()->with('success', "Status laporan #{$laporan->id} berhasil diubah dari '{$statusLama}' menjadi '{$request->status}'!");
    }

    // Menghapus laporan pengaduan
    public function destroy($id)
    {
        $laporan = Pengaduan::findOrFail($id);
        $laporan->delete();

        return redirect()->back()->with('success', "Laporan #{$id} berhasil dihapus.");
    }
}
