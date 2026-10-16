<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    // Tambahkan ini agar kolom bisa diisi melalui form (Mass Assignment)
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];
}