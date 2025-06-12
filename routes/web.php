<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\FirebaseLoginController;


Route::view('/', 'auth.login');
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');


Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');



Route::post('/verify-firebase-token', [FirebaseLoginController::class, 'verify']);
Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::get('/transaksi', function () {
    return view('admin.transaksi');
});

Route::get('/daftar-feedback', function () {
    return view('admin.daftar-feedback');
});

Route::get('/simpanan', function () {
    return view('simpanan');
});

Route::get('/profil', function () {
    return view('profil');
});

Route::get('/pinjaman', function () {
    return view('pinjaman');
});

Route::get('/feedback', function () {
    return view('feedback');
});

Route::get('/about', function () {
    return view('about');
});
