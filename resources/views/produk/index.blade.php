@extends('layouts.app')

@section('judul', 'Kelola Produk')

@section('konten')
    <section class="mx-auto max-w-4xl px-6 py-20">
        @if (session('status'))
            <p class="mb-8 border-l-2 border-neutral-900 pl-4 text-sm text-neutral-600">
                {{ session('status') }}
            </p>
        @endif

        <div class="flex items-center justify-between gap-6">
            <h1 class="text-xl font-medium tracking-tight">Kelola produk</h1>
            <a href="{{ route('produk.create') }}" class="bg-neutral-900 px-5 py-2.5 text-sm text-white hover:bg-neutral-700">
                Tambah produk
            </a>
        </div>

        @if ($produk->isEmpty())
            <p class="mt-8 text-sm text-neutral-600">Belum ada produk.</p>
        @else
            <div class="mt-8 overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-neutral-200 text-neutral-500">
                        <tr>
                            <th class="py-3 font-normal">Nama</th>
                            <th class="py-3 font-normal">Kategori</th>
                            <th class="py-3 text-right font-normal">Harga</th>
                            <th class="py-3 text-right font-normal">Stok</th>
                            <th class="py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200">
                        @foreach ($produk as $item)
                            <tr>
                                <td class="py-3">{{ $item->nama }}</td>
                                <td class="py-3 text-neutral-600">{{ $item->kategori }}</td>
                                <td class="py-3 text-right">Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td class="py-3 text-right">{{ $item->stok }}</td>
                                <td class="py-3">
                                    <div class="flex justify-end gap-4">
                                        <a href="{{ route('produk.edit', $item) }}" class="text-neutral-600 hover:text-neutral-900">Ubah</a>

                                        <form method="POST" action="{{ route('produk.destroy', $item) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection
