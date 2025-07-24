<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    KategoriController,
    BarangController,
    BarangMasukController,
    BarangKeluarController,
    TopsisController
};

Route::redirect('/', '/login');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Routes untuk Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('kategori', KategoriController::class);
        Route::resource('barang', BarangController::class);
        Route::get('/laporan/stok', [BarangController::class, 'laporanStok'])->name('laporan.stok');
    });
    
    // Routes untuk Pengurus
    Route::middleware(['role:pengurus,admin'])->group(function () {
        Route::resource('barang-masuk', BarangMasukController::class);
        Route::resource('barang-keluar', BarangKeluarController::class)->except(['edit', 'update']);
    });
    
    // Routes untuk Bendahara
    Route::middleware(['role:bendahara,admin'])->group(function () {
        Route::patch('/barang-keluar/{barangKeluar}/approve', [BarangKeluarController::class, 'approve'])->name('barang-keluar.approve');
        Route::patch('/barang-keluar/{barangKeluar}/reject', [BarangKeluarController::class, 'reject'])->name('barang-keluar.reject');
        
        // TOPSIS Routes
        Route::get('/topsis', [TopsisController::class, 'index'])->name('topsis.index');
        Route::post('/topsis/calculate', [TopsisController::class, 'calculate'])->name('topsis.calculate');
    });
});
