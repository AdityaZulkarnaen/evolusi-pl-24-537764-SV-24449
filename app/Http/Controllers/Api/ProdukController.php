<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\JsonResponse;

class ProdukController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Produk::latest()->get(['id', 'nama', 'kategori', 'harga', 'stok']),
        ]);
    }
}
