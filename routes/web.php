<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Admin Controllers
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminBarangController;
use App\Http\Controllers\Admin\AdminKategoriController;
use App\Http\Controllers\Admin\AdminBarangMasukController;
use App\Http\Controllers\Admin\AdminBarangKeluarController;
use App\Http\Controllers\Admin\AdminPengajuanController;
use App\Http\Controllers\Admin\AdminLaporanController;

// Bendahara Controllers
use App\Http\Controllers\Bendahara\BendaharaDashboardController;
use App\Http\Controllers\Bendahara\BendaharaAnggaranController;
use App\Http\Controllers\Bendahara\BendaharaPengajuanController;
use App\Http\Controllers\Bendahara\BendaharaTopsisController;
use App\Http\Controllers\Bendahara\BendaharaLaporanController;
use App\Http\Controllers\Bendahara\BendaharaValidasiController;

// Pengurus Controllers
use App\Http\Controllers\Pengurus\PengurusDashboardController;
use App\Http\Controllers\Pengurus\PengurusPengajuanController;
use App\Http\Controllers\Pengurus\PengurusBarangController;

Route::get('/', function () {
    return redirect()->route('login');
});

// =====================
// ROUTE MENU ADMIN
// =====================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // User Management Routes
    Route::resource('users', AdminUserController::class, ['as' => 'admin']);
    Route::post('users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('admin.users.reset-password');
    Route::post('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
    
    // Master Data Routes
    Route::resource('kategori', AdminKategoriController::class, ['as' => 'admin']);
    Route::resource('barang', AdminBarangController::class, ['as' => 'admin']);
    
    // Transaction Routes
    Route::resource('barang-masuk', AdminBarangMasukController::class, ['as' => 'admin']);
    Route::resource('barang-keluar', AdminBarangKeluarController::class, ['as' => 'admin']);
    Route::resource('pengajuan', AdminPengajuanController::class, ['as' => 'admin']);
    
    // Report Routes
    Route::prefix('laporan')->name('admin.laporan.')->group(function () {
        Route::get('/', [AdminLaporanController::class, 'index'])->name('index');
        Route::get('/barang', [AdminLaporanController::class, 'barang'])->name('barang');
        Route::get('/transaksi', [AdminLaporanController::class, 'transaksi'])->name('transaksi');
        Route::get('/pengajuan', [AdminLaporanController::class, 'pengajuan'])->name('pengajuan');
        Route::get('/export/pdf', [AdminLaporanController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/export/excel', [AdminLaporanController::class, 'exportExcel'])->name('export.excel');
    });
});

use App\Http\Controllers\Bendahara\DashboardController as BendaharaDashboardController;
use App\Http\Controllers\Bendahara\KasMasukController as BendaharaKasMasukController;
use App\Http\Controllers\Bendahara\PengajuanController as BendaharaPengajuanController;
use App\Http\Controllers\Bendahara\TopsisController as BendaharaTopsisController;
use App\Http\Controllers\Bendahara\LaporanController as BendaharaLaporanController;

// =====================
// ROUTE MENU BENDAHARA
// =====================
Route::prefix('bendahara')->middleware(['auth', 'role:bendahara'])->group(function () {
    // Dashboard & Overview
    Route::get('/dashboard', [BendaharaDashboardController::class, 'index'])->name('bendahara.dashboard');
    
    // Kas Management
    Route::prefix('kas-masuk')->name('bendahara.kas-masuk.')->group(function () {
        Route::get('/', [BendaharaKasMasukController::class, 'index'])->name('index');
        Route::get('/create', [BendaharaKasMasukController::class, 'create'])->name('create');
        Route::post('/', [BendaharaKasMasukController::class, 'store'])->name('store');
        Route::get('/{kasMasuk}', [BendaharaKasMasukController::class, 'show'])->name('show');
        Route::delete('/{kasMasuk}', [BendaharaKasMasukController::class, 'destroy'])->name('destroy');
    });
    
    // Verifikasi Pengajuan
    Route::prefix('verifikasi-pengajuan')->name('bendahara.verifikasi-pengajuan.')->group(function () {
        Route::get('/', [BendaharaPengajuanController::class, 'index'])->name('index');
        Route::get('/{pengajuan}', [BendaharaPengajuanController::class, 'show'])->name('show');
        Route::post('/{pengajuan}/verifikasi', [BendaharaPengajuanController::class, 'verifikasi'])->name('verifikasi');
        Route::post('/{pengajuan}/tolak', [BendaharaPengajuanController::class, 'tolak'])->name('tolak');
    });
    
    // TOPSIS Analysis
    Route::prefix('analisis-topsis')->name('bendahara.analisis-topsis.')->group(function () {
        Route::get('/', [BendaharaTopsisController::class, 'index'])->name('index');
        Route::get('/kriteria', [BendaharaTopsisController::class, 'kriteria'])->name('kriteria');
        Route::post('/hitung', [BendaharaTopsisController::class, 'hitung'])->name('hitung');
        Route::get('/hasil', [BendaharaTopsisController::class, 'hasil'])->name('hasil');
        Route::get('/export-pdf', [BendaharaTopsisController::class, 'exportPdf'])->name('export.pdf');
    });
    
    // Reports
    Route::prefix('laporan')->name('bendahara.laporan.')->group(function () {
        Route::get('/', [BendaharaLaporanController::class, 'index'])->name('index');
        Route::get('/kas', [BendaharaLaporanController::class, 'kas'])->name('kas');
        Route::get('/pengajuan', [BendaharaLaporanController::class, 'pengajuan'])->name('pengajuan');
        Route::get('/topsis', [BendaharaLaporanController::class, 'topsis'])->name('topsis');
        Route::get('/export-pdf/{type}', [BendaharaLaporanController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/export-excel/{type}', [BendaharaLaporanController::class, 'exportExcel'])->name('export.excel');
    });
});

// =====================
// ROUTE MENU PENGURUS
// =====================
Route::prefix('pengurus')->middleware(['auth', 'role:pengurus'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [PengurusDashboardController::class, 'index'])->name('pengurus.dashboard');
    
    // Inventory Management
    Route::resource('barang-masuk', PengurusBarangMasukController::class, ['as' => 'pengurus']);
    Route::resource('barang-keluar', PengurusBarangKeluarController::class, ['as' => 'pengurus']);
    
    // Pengajuan Management
    Route::resource('pengajuan', PengurusPengajuanController::class, ['as' => 'pengurus']);
    Route::get('riwayat-pengajuan', [PengurusPengajuanController::class, 'riwayat'])->name('pengurus.riwayat-pengajuan');
    
    // Inventory Check
    Route::get('stok-barang', [PengurusBarangController::class, 'index'])->name('pengurus.stok.index');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Fallback route untuk menangani sesi yang expired
Route::fallback(function () {
    return redirect()->route('login');
});
