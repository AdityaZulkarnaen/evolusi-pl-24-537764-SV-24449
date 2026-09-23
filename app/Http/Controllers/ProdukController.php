<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProdukController extends Controller
{
    public function index(): View
    {
        return view('produk.index', [
            'produk' => Produk::latest()->get(),
        ]);
    }

    public function create(): View
    {
        return view('produk.form', ['produk' => new Produk, 'kategori' => Produk::KATEGORI]);
    }

    public function store(Request $request): RedirectResponse
    {
        Produk::create($this->validasi($request));

        return redirect()->route('produk.index')->with('status', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk): View
    {
        return view('produk.form', ['produk' => $produk, 'kategori' => Produk::KATEGORI]);
    }

    public function update(Request $request, Produk $produk): RedirectResponse
    {
        $produk->update($this->validasi($request));

        return redirect()->route('produk.index')->with('status', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk): RedirectResponse
    {
        $produk->delete();

        return redirect()->route('produk.index')->with('status', 'Produk berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validasi(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['required', Rule::in(Produk::KATEGORI)],
            'harga' => ['required', 'integer', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
        ]);
    }
}
