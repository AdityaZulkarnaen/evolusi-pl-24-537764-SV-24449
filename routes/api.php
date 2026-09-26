<?php

use App\Http\Controllers\Api\ProdukController;
use Illuminate\Support\Facades\Route;

Route::get('/produk', [ProdukController::class, 'index'])->name('api.produk.index');
