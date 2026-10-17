<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::query()->delete();

        $kategoris = [
            'Fasilitas Kelas',
            'Laboratorium',
            'Toilet & Kebersihan',
            'Jaringan Wi-Fi & Internet',
            'Listrik & AC',
            'Perpustakaan',
            'Halaman & Parkir Kampus',
            'Ruang Kuliah / Auditorium',
        ];

        foreach ($kategoris as $nama) {
            Kategori::create([
                'nama_kategori' => $nama,
                'deskripsi' => 'Kategori kerusakan fasilitas kampus.',
            ]);
        }
    }
}
