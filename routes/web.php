<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

// =====================
// ROUTE MENU ADMIN
// =====================
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
// Tambahkan controller admin lain jika ada

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('users', [AdminUserController::class, 'index'])->name('admin.users.index');
    // Tambahkan route admin lain di sini
});

// =====================
// ROUTE MENU BENDAHARA
// =====================
use App\Http\Controllers\Bendahara\DashboardController as BendaharaDashboardController;
use App\Http\Controllers\Bendahara\AnggaranController as BendaharaAnggaranController;
use App\Http\Controllers\Bendahara\PengajuanController as BendaharaPengajuanController;
use App\Http\Controllers\Bendahara\TopsisController as BendaharaTopsisController;
use App\Http\Controllers\Bendahara\LaporanController as BendaharaLaporanController;
use App\Http\Controllers\Bendahara\ValidasiController as BendaharaValidasiController;

Route::prefix('bendahara')->middleware(['auth', 'role:bendahara'])->group(function () {
    Route::get('dashboard', [BendaharaDashboardController::class, 'index'])->name('bendahara.dashboard');
    Route::get('anggaran', [BendaharaAnggaranController::class, 'index'])->name('bendahara.anggaran.index');
    Route::post('anggaran', [BendaharaAnggaranController::class, 'store'])->name('bendahara.anggaran.store');
    Route::get('anggaran/riwayat', [BendaharaAnggaranController::class, 'riwayat'])->name('bendahara.anggaran.riwayat');
    Route::get('pengajuan', [BendaharaPengajuanController::class, 'index'])->name('bendahara.pengajuan.index');
    Route::get('pengajuan/{id}', [BendaharaPengajuanController::class, 'show'])->name('bendahara.pengajuan.show');
    Route::post('pengajuan/{id}/verifikasi', [BendaharaPengajuanController::class, 'verifikasi'])->name('bendahara.pengajuan.verifikasi');
    Route::get('topsis', [BendaharaTopsisController::class, 'index'])->name('bendahara.topsis.index');
    Route::post('topsis/hitung', [BendaharaTopsisController::class, 'hitung'])->name('bendahara.topsis.hitung');
    Route::get('topsis/ekspor', [BendaharaTopsisController::class, 'eksporPdf'])->name('bendahara.topsis.ekspor');
    Route::get('laporan', [BendaharaLaporanController::class, 'index'])->name('bendahara.laporan.index');
    Route::get('laporan/ekspor', [BendaharaLaporanController::class, 'eksporPdf'])->name('bendahara.laporan.ekspor');
    Route::get('validasi', [BendaharaValidasiController::class, 'index'])->name('bendahara.validasi.index');
});

// =====================
// ROUTE MENU PENGURUS
// =====================
use App\Http\Controllers\Pengurus\DashboardController as PengurusDashboardController;
// Tambahkan controller pengurus lain jika ada

Route::prefix('pengurus')->middleware(['auth', 'role:pengurus'])->group(function () {
    Route::get('dashboard', [PengurusDashboardController::class, 'index'])->name('pengurus.dashboard');
    // Tambahkan route pengurus lain di sini
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if (!$user) {
        return redirect()->route('login');
    }
    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'bendahara':
            return redirect()->route('bendahara.dashboard');
        case 'pengurus':
            return redirect()->route('pengurus.dashboard');
        default:
            return redirect()->route('login');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\TopsisController;
use App\Http\Controllers\LaporanController;
Route::middleware(['auth'])->group(function () {
    Route::resource('barang', BarangController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('barang-masuk', BarangMasukController::class);
    Route::resource('barang-keluar', BarangKeluarController::class);
    Route::resource('pengajuan', PengajuanController::class);
    Route::resource('laporan', LaporanController::class);
});
