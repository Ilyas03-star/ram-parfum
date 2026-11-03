@extends('layouts.app')

@section('title', 'Dashboard Admin - RAM Parfum')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12 space-y-8">
    <h1 class="text-3xl font-extrabold text-zinc-100">Dashboard Admin RAM Parfum</h1>

    <!-- Kartu Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-2xl shadow-xl">
            <span class="text-xs text-zinc-400 uppercase tracking-wider font-bold">Total Produk</span>
            <div class="text-3xl font-extrabold gold-text mt-2">{{ $totalProducts }} Produk</div>
        </div>
        <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-2xl shadow-xl">
            <span class="text-xs text-zinc-400 uppercase tracking-wider font-bold">Total Pesanan Masuk</span>
            <div class="text-3xl font-extrabold gold-text mt-2">{{ $totalOrders }} Pesanan</div>
        </div>
    </div>

    <!-- Daftar Pesanan Terbaru & Verifikasi Pembayaran -->
    <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-2xl shadow-xl space-y-4">
        <h2 class="text-xl font-bold text-zinc-100">Daftar Pesanan Terbaru & Bukti Pembayaran</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-zinc-800 text-zinc-400 text-xs uppercase tracking-wider">
                        <th class="p-4">No. Pesanan</th>
                        <th class="p-4">Pembeli</th>
                        <th class="p-4">Detail Produk & Ukuran</th>
                        <th class="p-4">Total Harga</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Bukti Transfer</th>
                        <th class="p-4 text-center">Aksi Tindak Lanjut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800 text-sm text-zinc-200">
                    @forelse($orders as $order)
                    <tr class="hover:bg-zinc-950/50 transition">
                        <td class="p-4 font-bold text-amber-400">{{ $order->order_number }}</td>
                        <td class="p-4">{{ $order->user->name ?? 'Guest' }}</td>
                        <td class="p-4 space-y-1">
                            @foreach($order->items as $item)
                                <div class="text-xs">
                                    <span class="font-bold text-zinc-100">{{ $item->product->name ?? 'Produk Dihapus' }}</span>
                                    <div class="text-amber-400 font-semibold">
                                        Ukuran: {{ $item->size ?? 'Standard' }} | Qty: {{ $item->quantity }}
                                    </div>
                                </div>
                            @endforeach
                        </td>
                        <td class="p-4 font-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td class="p-4">
                            @if($order->status == 'pending')
                                <span class="bg-yellow-900/50 text-yellow-300 px-2.5 py-1 rounded-full text-xs font-semibold">Menunggu Pembayaran</span>
                            @elseif($order->status == 'waiting_confirmation')
                                <span class="bg-blue-900/50 text-blue-300 px-2.5 py-1 rounded-full text-xs font-semibold">Menunggu Konfirmasi</span>
                            @elseif($order->status == 'processing')
                                <span class="bg-indigo-900/50 text-indigo-300 px-2.5 py-1 rounded-full text-xs font-semibold">Diproses / Dikirim</span>
                            @elseif($order->status == 'completed')
                                <span class="bg-green-900/50 text-green-300 px-2.5 py-1 rounded-full text-xs font-semibold">Selesai / Diterima</span>
                            @else
                                <span class="bg-red-900/50 text-red-300 px-2.5 py-1 rounded-full text-xs font-semibold">Ditolak / Dibatalkan</span>
                            @endif
                        </td>
                        <td class="p-4">
                            @if($order->payment && $order->payment->proof_image)
                                <a href="{{ asset($order->payment->proof_image) }}" target="_blank" class="text-amber-400 hover:underline flex items-center gap-1 text-xs font-bold">
                                    <i class="fa-solid fa-image"></i> Lihat Bukti
                                </a>
                            @else
                                <span class="text-xs text-zinc-500">Belum Upload</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-1.5 flex-wrap">
                                <!-- Tombol Proses / Kirim -->
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="processing">
                                    <button type="submit" class="bg-indigo-700 hover:bg-indigo-600 text-white text-xs font-bold px-2.5 py-1.5 rounded-lg transition" title="Proses Pesanan">
                                        Proses
                                    </button>
                                </form>

                                <!-- Tombol Selesai / Terima -->
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="bg-green-700 hover:bg-green-600 text-white text-xs font-bold px-2.5 py-1.5 rounded-lg transition" title="Selesaikan Pesanan">
                                        Terima
                                    </button>
                                </form>

                                <!-- Tombol Tolak / Cancel -->
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="bg-red-700 hover:bg-red-600 text-white text-xs font-bold px-2.5 py-1.5 rounded-lg transition" title="Tolak Pesanan">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-6 text-center text-zinc-500">Belum ada pesanan yang masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection