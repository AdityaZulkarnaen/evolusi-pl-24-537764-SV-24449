<?php

namespace Tests\Feature;

use App\Models\Produk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdukApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_endpoint_mengembalikan_daftar_produk_sebagai_json(): void
    {
        Produk::factory()->create([
            'nama' => 'Kursi Kayu Ek',
            'kategori' => 'Furnitur',
            'harga' => 1250000,
            'stok' => 4,
        ]);

        $this->getJson('/api/produk')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.nama', 'Kursi Kayu Ek')
            ->assertJsonPath('data.0.harga', 1250000)
            ->assertJsonStructure(['data' => [['id', 'nama', 'kategori', 'harga', 'stok']]]);
    }

    public function test_endpoint_mengembalikan_data_kosong_saat_tabel_kosong(): void
    {
        $this->getJson('/api/produk')
            ->assertOk()
            ->assertExactJson(['data' => []]);
    }

    public function test_endpoint_dapat_diakses_tanpa_login(): void
    {
        $this->getJson('/api/produk')->assertOk();
    }

    public function test_alamat_frontend_diizinkan_oleh_cors(): void
    {
        $this->getJson('/api/produk', ['Origin' => 'http://localhost:5174'])
            ->assertHeader('Access-Control-Allow-Origin', 'http://localhost:5174');
    }
}
