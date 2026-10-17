<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login'); 
});

Route::middleware('auth')->group(function () {
    // Ini secara otomatis mendaftarkan semua rute: index, create, store, edit, update, destroy
    Route::resource('kategori', KategoriController::class);

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Panel Khusus Admin: Kelola Laporan Masuk (Dilindungi AdminMiddleware)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
        Route::patch('/laporan/{id}/status', [AdminLaporanController::class, 'updateStatus'])->name('laporan.update-status');
        Route::delete('/laporan/{id}', [AdminLaporanController::class, 'destroy'])->name('laporan.destroy');
    });
});

require __DIR__.'/auth.php';