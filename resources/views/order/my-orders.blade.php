@extends('layouts.app')

@section('title', 'Pesanan Saya - RAM Parfum')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12 space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-extrabold text-zinc-100">Riwayat Pesanan & Status Transaksi</h1>
        <a href="{{ route('home') }}" class="text-xs gold-text hover:underline font-bold">← Lanjut Belanja</a>
    </div>

    @if(session('success'))
        <div class="bg-green-900/50 border border-green-700 text-green-300 p-4 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-4">
        @forelse($orders as $order)
        <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-2xl shadow-xl space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-4 border-b border-zinc-800 pb-4">
                <div>
                    <span class="text-xs text-zinc-400 uppercase tracking-wider">No. Pesanan:</span>
                    <div class="text-amber-400 font-extrabold text-lg">{{ $order->order_number }}</div>
                    <span class="text-[11px] text-zinc-500">{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div>
                    <span class="text-xs text-zinc-400 uppercase tracking-wider block">Status Pesanan:</span>
                    @if($order->status == 'pending')
                        <span class="bg-yellow-900/50 text-yellow-300 px-3 py-1 rounded-full text-xs font-bold">Menunggu Pembayaran</span>
                    @elseif($order->status == 'waiting_confirmation')
                        <span class="bg-blue-900/50 text-blue-300 px-3 py-1 rounded-full text-xs font-bold">Menunggu Konfirmasi Admin</span>
                    @elseif($order->status == 'processing')
                        <span class="bg-indigo-900/50 text-indigo-300 px-3 py-1 rounded-full text-xs font-bold">Sedang Diproses / Dikirim</span>
                    @elseif($order->status == 'completed')
                        <span class="bg-green-900/50 text-green-300 px-3 py-1 rounded-full text-xs font-bold">Selesai / Diterima</span>
                    @elseif($order->status == 'cancelled')
                        <span class="bg-red-900/50 text-red-300 px-3 py-1 rounded-full text-xs font-bold">Ditolak / Dibatalkan oleh Admin</span>
                    @endif
                </div>
            </div>

            <!-- Detail Produk yang Dibeli -->
            <div class="space-y-2">
                <h4 class="text-xs font-bold text-zinc-400 uppercase">Produk yang Dibeli:</h4>
                <div class="divide-y divide-zinc-800/60">
                    @foreach($order->items as $item)
                    py-2 flex items-center justify-between text-sm">
                        <div class="flex items-center gap-3">
                            <div>
                                <div class="font-bold text-zinc-200">{{ $item->product->name ?? 'Produk' }}</div>
                                <div class="text-xs text-amber-400">Ukuran: {{ $item->size ?? 'Standard' }} | Qty: {{ $item->quantity }}</div>
                            </div>
                        </div>
                        <div class="font-semibold text-zinc-300">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-4 pt-4 border-t border-zinc-800">
                <div class="text-sm">
                    <span class="text-zinc-400">Total Pembayaran: </span>
                    <span class="font-extrabold text-amber-400 text-base">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>

                <!-- Tombol Konfirmasi Pesanan Selesai oleh Pembeli -->
                @if($order->status == 'processing' || $order->status == 'waiting_confirmation')
                <form action="{{ route('orders.complete', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-600 hover:bg-green-500 text-zinc-950 font-bold px-4 py-2 rounded-xl text-xs transition shadow flex items-center gap-2">
                        <i class="fa-solid fa-check-double"></i> Konfirmasi Barang Sudah Sampai
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-zinc-900 border border-zinc-800 p-12 rounded-2xl text-center space-y-3">
            <i class="fa-solid fa-basket-shopping text-4xl text-zinc-600"></i>
            <p class="text-zinc-400 text-sm">Belum ada riwayat transaksi atau pesanan di keranjang Anda.</p>
            <a href="{{ route('home') }}" class="inline-block gold-bg text-zinc-950 font-bold px-6 py-2.5 rounded-xl text-xs hover:bg-amber-400 transition">
                Mulai Belanja Parfum
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection