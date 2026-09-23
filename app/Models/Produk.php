<?php

namespace App\Models;

use Database\Factories\ProdukFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Table('produk')]
#[Fillable(['nama', 'kategori', 'harga', 'stok'])]
class Produk extends Model
{
    /** @use HasFactory<ProdukFactory> */
    use HasFactory;

    public const KATEGORI = ['Furnitur', 'Dapur', 'Dekorasi', 'Alat Tulis'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'harga' => 'integer',
            'stok' => 'integer',
        ];
    }
}
