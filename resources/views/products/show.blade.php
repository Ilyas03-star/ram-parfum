@extends('layouts.app')

@section('title', $product->name . ' - RAM Parfum')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 bg-zinc-900 border border-zinc-800 p-8 rounded-2xl">
        
        <!-- Foto Produk -->
        <div class="h-80 bg-zinc-950 rounded-xl overflow-hidden flex items-center justify-center border border-zinc-800 relative">
            @if($product->image)
                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover">
            @else
                <i class="fa-solid fa-bottle-droplet text-8xl gold-text opacity-50"></i>
            @endif
        </div>

        <!-- Detail & Pilihan Ukuran -->
        <div class="space-y-6 flex flex-col justify-between">
            <div class="space-y-4">
                <span class="text-xs uppercase tracking-wider gold-text font-bold">{{ $product->category }}</span>
                <h1 class="text-3xl font-extrabold text-zinc-100">{{ $product->name }}</h1>
                
                <!-- Harga Dinamis -->
                <p class="text-2xl font-bold gold-text" id="product-price">
                    Rp {{ number_format($product->variants->first()->price ?? $product->price, 0, ',', '.') }}
                </p>
                
                <div class="bg-zinc-950 p-4 rounded-xl border border-zinc-800 text-sm space-y-2">
                    <p class="font-bold text-amber-400"><i class="fa-solid fa-spray-can mr-1"></i> Karakter & Ciri Aroma:</p>
                    <p class="text-zinc-300 leading-relaxed">{{ $product->scent_notes }}</p>
                </div>

                <p class="text-zinc-400 text-sm leading-relaxed">{{ $product->description }}</p>
            </div>

            <!-- Form Checkout dengan Pilihan Ukuran Botol -->
            @auth
                <form action="{{ route('checkout') }}" method="POST" class="pt-4 border-t border-zinc-800 space-y-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <!-- Pilihan Ukuran Botol (Radio Button) -->
                    <div>
                        <label class="block text-xs text-zinc-400 mb-2 font-bold uppercase tracking-wider">Pilih Ukuran Botol:</label>
                        <div class="flex flex-wrap gap-3">
                            @foreach($product->variants as $index => $variant)
                                <label class="cursor-pointer border border-zinc-700 bg-zinc-950 px-4 py-2.5 rounded-xl text-sm font-semibold text-zinc-200 hover:border-amber-400 transition flex items-center space-x-2">
                                    <input type="radio" name="variant_id" value="{{ $variant->id }}" 
                                           data-price="{{ $variant->price }}" 
                                           class="text-amber-500 focus:ring-0 variant-radio" 
                                           {{ $index === 0 ? 'checked' : '' }} required>
                                    <span>{{ $variant->size }} (Stok: {{ $variant->stock }})</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs text-zinc-400 mb-1">Alamat Pengiriman Lengkap:</label>
                        <textarea name="shipping_address" required rows="2" class="w-full bg-zinc-950 border border-zinc-700 rounded-lg p-2.5 text-sm text-zinc-200 focus:outline-none focus:border-amber-400" placeholder="Alamat rumah, jalan, RT/RW, kota..."></textarea>
                    </div>

                    <button type="submit" class="w-full gold-bg text-zinc-950 font-bold py-3 rounded-xl hover:bg-amber-400 transition">
                        Beli Sekarang (QRIS DANA)
                    </button>
                </form>
            @else
                <div class="p-4 bg-zinc-950 rounded-xl border border-zinc-800 text-center space-y-2">
                    <p class="text-sm text-zinc-400">Silakan login terlebih dahulu untuk melakukan pembelian.</p>
                    <a href="{{ route('login') }}" class="inline-block gold-text font-bold text-sm hover:underline">Login Sekarang &rarr;</a>
                </div>
            @endauth
        </div>
    </div>
</div>

<!-- Script JavaScript untuk Ubah Harga Otomatis Saat Ukuran Diklik -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const radios = document.querySelectorAll('.variant-radio');
        const priceElement = document.getElementById('product-price');

        radios.forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.checked) {
                    const price = parseInt(this.getAttribute('data-price'));
                    // Format ke Rupiah otomatis
                    priceElement.textContent = 'Rp ' + price.toLocaleString('id-ID');
                }
            });
        });
    });
</script>
@endsection