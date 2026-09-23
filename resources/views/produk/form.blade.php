@extends('layouts.app')

@section('judul', $produk->exists ? 'Ubah Produk' : 'Tambah Produk')

@section('konten')
    <section class="mx-auto max-w-sm px-6 py-20">
        <h1 class="text-xl font-medium tracking-tight">
            {{ $produk->exists ? 'Ubah produk' : 'Tambah produk' }}
        </h1>
        <p class="mt-2 text-sm text-neutral-600">
            <a href="{{ route('produk.index') }}" class="text-neutral-900 underline">Kembali ke daftar produk</a>
        </p>

        <form method="POST"
              action="{{ $produk->exists ? route('produk.update', $produk) : route('produk.store') }}"
              class="mt-8 space-y-5">
            @csrf
            @if ($produk->exists)
                @method('PUT')
            @endif

            <x-kolom-isian nama="nama" label="Nama produk" :nilai="$produk->nama" />

            <div>
                <label for="kategori" class="block text-sm text-neutral-900">Kategori</label>

                <select id="kategori" name="kategori" required @class([
                    'mt-2 w-full border px-3 py-2 text-sm focus:outline-none',
                    'border-neutral-300 focus:border-neutral-900' => ! $errors->has('kategori'),
                    'border-red-500' => $errors->has('kategori'),
                ])>
                    @foreach ($kategori as $pilihan)
                        <option value="{{ $pilihan }}" @selected(old('kategori', $produk->kategori) === $pilihan)>
                            {{ $pilihan }}
                        </option>
                    @endforeach
                </select>

                @error('kategori')
                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <x-kolom-isian nama="harga" label="Harga (Rp)" tipe="number" :nilai="$produk->harga" min="0" />
            <x-kolom-isian nama="stok" label="Stok" tipe="number" :nilai="$produk->stok" min="0" />

            <button type="submit" class="w-full bg-neutral-900 px-5 py-2.5 text-sm text-white hover:bg-neutral-700">
                Simpan
            </button>
        </form>
    </section>
@endsection
