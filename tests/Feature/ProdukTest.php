<?php

namespace Tests\Feature;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdukTest extends TestCase
{
    use RefreshDatabase;

    public function test_tamu_diarahkan_ke_halaman_masuk(): void
    {
        $this->get('/produk')->assertRedirect(route('login'));
    }

    public function test_daftar_produk_menampilkan_isi_tabel(): void
    {
        Produk::factory()->create(['nama' => 'Kursi Kayu Ek', 'harga' => 1250000]);

        $this->actingAs(User::factory()->create())
            ->get(route('produk.index'))
            ->assertOk()
            ->assertSee('Kursi Kayu Ek')
            ->assertSee('Rp9.999.999');
    }

    public function test_formulir_tambah_dan_ubah_dapat_diakses(): void
    {
        $produk = Produk::factory()->create(['nama' => 'Vas Bunga Tanah Liat']);

        $this->actingAs(User::factory()->create());

        $this->get(route('produk.create'))->assertOk()->assertSee('Tambah produk');
        $this->get(route('produk.edit', $produk))->assertOk()->assertSee('Vas Bunga Tanah Liat');
    }

    public function test_produk_baru_dapat_ditambahkan(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('produk.store'), [
                'nama' => 'Lampu Meja Linen',
                'kategori' => 'Dekorasi',
                'harga' => 480000,
                'stok' => 12,
            ])
            ->assertRedirect(route('produk.index'));

        $this->assertDatabaseHas('produk', ['nama' => 'Lampu Meja Linen', 'stok' => 12]);
    }

    public function test_penambahan_menolak_data_yang_tidak_valid(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('produk.store'), [
                'nama' => '',
                'kategori' => 'Elektronik',
                'harga' => -1,
                'stok' => 'banyak',
            ])
            ->assertSessionHasErrors(['nama', 'kategori', 'harga', 'stok']);

        $this->assertDatabaseCount('produk', 0);
    }

    public function test_produk_dapat_diubah(): void
    {
        $produk = Produk::factory()->create(['harga' => 95000]);

        $this->actingAs(User::factory()->create())
            ->put(route('produk.update', $produk), [
                'nama' => 'Cangkir Keramik 300 ml',
                'kategori' => 'Dapur',
                'harga' => 105000,
                'stok' => 5,
            ])
            ->assertRedirect(route('produk.index'));

        $this->assertSame(105000, $produk->fresh()->harga);
        $this->assertSame('Cangkir Keramik 300 ml', $produk->fresh()->nama);
    }

    public function test_produk_dapat_dihapus(): void
    {
        $produk = Produk::factory()->create();

        $this->actingAs(User::factory()->create())
            ->delete(route('produk.destroy', $produk))
            ->assertRedirect(route('produk.index'));

        $this->assertModelMissing($produk);
    }
}
