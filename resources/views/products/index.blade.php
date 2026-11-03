@extends('layouts.app')

@section('title', 'RAM Parfum - Katalog & Pencarian Aroma')

@section('content')
<!-- Hero Section & Pencarian Ciri Aroma -->
<div class="bg-gradient-to-b from-zinc-900 to-zinc-950 py-16 px-4 border-b border-zinc-800">
    <div class="max-w-4xl mx-auto text-center space-y-6">
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight">
            Temukan Karakter Aromamu di <span class="gold-text">RAM Parfum</span>
        </h1>
        <p class="text-zinc-400 text-lg">
            Ketik nama parfum atau <span class="text-amber-400 font-semibold">ciri-ciri aroma</span> yang kamu inginkan (misal: <i>"manis vanilla", "segar buah", "kayu hangat"</i>).
        </p>

        <!-- Form Pencarian Cerdas -->
        <form action="{{ route('home') }}" method="GET" class="flex flex-col sm:flex-row gap-3 max-w-2xl mx-auto">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-zinc-500"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari ciri aroma (contoh: manis, segar, maskulin, kayu)..." 
                    class="w-full bg-zinc-900 border border-zinc-700 rounded-xl pl-11 pr-4 py-3.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:border-amber-400">
            </div>
            <button type="submit" class="gold-bg text-zinc-950 px-6 py-3.5 rounded-xl font-bold hover:bg-amber-400 transition">
                Cari Aroma
            </button>
        </form>
    </div>
</div>

<!-- Katalog Produk -->
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-bold">Katalog Parfum</h2>
        @if(request('search'))
            <a href="{{ route('home') }}" class="text-sm text-amber-400 hover:underline">Reset Pencarian</a>
        @endif
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($products as $product)
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden hover:border-amber-500/50 transition duration-300 flex flex-col justify-between group">
                <div>
                    <!-- Tampilan Gambar / Placeholder -->
                    <div class="h-64 bg-zinc-800 flex items-center justify-center text-zinc-600 relative overflow-hidden">
    @if($product->image)
        <!-- PERBAIKAN DI SINI (Hapus kata 'storage/') -->
        <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}" 
             alt="{{ $product->name }}" 
             class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
    @else
        <i class="fa-solid fa-bottle-droplet text-6xl gold-text opacity-40"></i>
    @endif
</div>

                    <div class="p-6 space-y-3">
                        <span class="text-xs uppercase tracking-wider gold-text font-bold">{{ $product->category }}</span>
                        <h3 class="text-xl font-bold text-zinc-100">{{ $product->name }}</h3>
                        
                        <!-- Ciri Aroma / Scent Notes -->
                        <div class="bg-zinc-950 p-3 rounded-lg border border-zinc-800 text-xs text-zinc-300 space-y-1">
                            <p class="font-semibold text-amber-400"><i class="fa-solid fa-wind mr-1"></i> Ciri Aroma / Notes:</p>
                            <p class="line-clamp-2 text-zinc-400">{{ $product->scent_notes }}</p>
                        </div>

                        <p class="text-zinc-400 text-sm line-clamp-2">{{ $product->description }}</p>
                    </div>
                </div>

                <div class="p-6 pt-0 flex items-center justify-between mt-4">
                    <div>
                        <p class="text-xs text-zinc-500">Harga</p>
                        <p class="text-lg font-bold text-zinc-100">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                    <a href="{{ route('products.show', $product->slug) }}" class="bg-zinc-800 hover:bg-zinc-700 text-zinc-200 text-sm font-semibold px-4 py-2.5 rounded-lg border border-zinc-700 transition">
                        Detail Produk
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-zinc-500 space-y-3">
                <i class="fa-solid fa-box-open text-4xl"></i>
                <p>Tidak ada parfum yang cocok dengan pencarian ciri aroma Anda.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection