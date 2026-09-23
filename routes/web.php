<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\Auth\PendaftaranController;
use App\Http\Controllers\Auth\SesiController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TentangController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/tentang', [TentangController::class, 'index'])->name('tentang');

Route::middleware('guest')->group(function () {
    Route::get('/daftar', [PendaftaranController::class, 'create'])->name('register');
    Route::post('/daftar', [PendaftaranController::class, 'store'])->middleware('throttle:6,1');

    Route::get('/masuk', [SesiController::class, 'create'])->name('login');
    Route::post('/masuk', [SesiController::class, 'store'])->middleware('throttle:6,1');
});

Route::middleware('auth')->group(function () {
    Route::get('/akun', [AkunController::class, 'index'])->name('akun');
    Route::post('/keluar', [SesiController::class, 'destroy'])->name('logout');

    Route::resource('produk', ProdukController::class)->except('show');
});
