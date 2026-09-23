<?php

namespace Database\Factories;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => ucfirst(fake()->words(3, true)),
            'kategori' => fake()->randomElement(Produk::KATEGORI),
            'harga' => fake()->numberBetween(50, 1500) * 1000,
            'stok' => fake()->numberBetween(0, 50),
        ];
    }
}
