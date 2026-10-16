<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul_laporan',
        'lokasi',
        'deskripsi',
        'foto',
        'status',
    ];

    // Relasi ke User (Pembuat Laporan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}