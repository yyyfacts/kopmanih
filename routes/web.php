<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;

// Admin Controllers
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\BarangController as AdminBarangController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\BarangMasukController as AdminBarangMasukController;
use App\Http\Controllers\Admin\BarangKeluarController as AdminBarangKeluarController;
use App\Http\Controllers\Admin\PengajuanController as AdminPengajuanController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;

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
    
    // User Management Routes
    Route::get('users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::get('users/create', [UserManagementController::class, 'create'])->name('admin.users.create');
    Route::post('users', [UserManagementController::class, 'store'])->name('admin.users.store');
    Route::get('users/{user}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
    Route::put('users/{user}', [UserManagementController::class, 'update'])->name('admin.users.update');
    Route::post('users/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('admin.users.reset-password');
    Route::post('users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('admin.users.toggle-status');
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


Route::get('/dashboard', function() {
    $role = auth()->user()->role ?? null;
    if ($role === 'admin') return redirect()->route('admin.dashboard');
    if ($role === 'bendahara') return redirect()->route('bendahara.dashboard');
    if ($role === 'pengurus') return redirect()->route('pengurus.dashboard');
    return redirect()->route('login');
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
    Route::resource('barang', AdminBarangController::class);
    Route::resource('kategori', AdminKategoriController::class);
    Route::resource('barang-masuk', AdminBarangMasukController::class);
    Route::resource('barang-keluar', AdminBarangKeluarController::class);
    Route::resource('pengajuan', AdminPengajuanController::class);
    Route::resource('laporan', AdminLaporanController::class);
});
