<header class="border-b border-neutral-200">
    <div class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-6 px-6">
        <a href="{{ route('beranda') }}" class="text-base font-semibold tracking-tight">
            Ruang Rumah
        </a>

        <nav class="hidden items-center gap-8 text-sm text-neutral-600 md:flex">
            <a href="{{ route('beranda') }}#produk" class="hover:text-neutral-900">Produk</a>
            <a href="{{ route('beranda') }}#produk" class="hover:text-neutral-900">Koleksi</a>
            <a href="{{ route('beranda') }}#layanan" class="hover:text-neutral-900">Layanan</a>
            <a href="{{ route('tentang') }}" class="hover:text-neutral-900">Tentang</a>
        </nav>

        <div class="flex items-center gap-6 text-sm">
            @auth
                <a href="{{ route('produk.index') }}" class="text-neutral-600 hover:text-neutral-900">Kelola produk</a>

                <a href="{{ route('akun') }}" class="text-neutral-600 hover:text-neutral-900">
                    {{ auth()->user()->name }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-neutral-600 hover:text-neutral-900">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hidden text-neutral-600 hover:text-neutral-900 sm:inline">Masuk</a>
                <a href="{{ route('register') }}" class="text-neutral-900 hover:underline">Daftar</a>
            @endauth

            <a href="#" class="text-neutral-900 hover:underline">Keranjang (0)</a>
        </div>
    </div>
</header>
