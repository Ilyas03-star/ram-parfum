@extends('layouts.app')

@section('title', 'Pembayaran QRIS - RAM Parfum')

@section('content')
<div class="max-w-xl mx-auto px-4 py-12">
    <div class="bg-zinc-900 border border-zinc-800 p-8 rounded-2xl shadow-xl space-y-6">
        <div class="text-center space-y-2">
            <h1 class="text-2xl font-bold text-zinc-100">Selesaikan Pembayaran</h1>
            <p class="text-xs text-zinc-400">Nomor Pesanan: <span class="text-amber-400 font-bold">{{ $order->order_number }}</span></p>
            <div class="text-xl font-extrabold text-amber-400 pt-2">
                Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}
            </div>
        </div>

        <div class="bg-zinc-950 p-5 rounded-xl border border-zinc-800 space-y-4">
            <h3 class="text-xs font-bold text-amber-400 uppercase tracking-wider"><i class="fa-solid fa-qrcode mr-1"></i> Scan QRIS DANA / E-Wallet</h3>
            
            <!-- Tombol untuk memunculkan QRIS -->
            <button type="button" id="show-qris-btn" class="w-full bg-zinc-800 hover:bg-zinc-700 text-zinc-200 text-xs font-bold py-3 rounded-xl transition border border-zinc-700 flex items-center justify-center gap-2">
                <i class="fa-solid fa-eye text-amber-400"></i> Klik untuk Munculkan Kode QRIS
            </button>

            <!-- Gambar QRIS (Awalnya disembunyikan dengan kelas hidden) -->
            <div id="qris-container" class="hidden space-y-3 p-4 bg-zinc-900 rounded-xl border border-zinc-800 text-center">
                <p class="text-xs text-zinc-400">Silakan scan kode QRIS di bawah ini menggunakan aplikasi DANA, OVO, GoPay, atau Mobile Banking:</p>
                <!-- Pastikan gambar qris-dana.jpg sudah ada di folder public/images/ -->
                <img src="{{ asset('images/qris-dana.jpg') }}" alt="QRIS RAM Parfum" class="w-52 h-52 mx-auto rounded-lg border border-zinc-700 object-contain bg-white p-2 shadow-md">
                <p class="text-[11px] text-amber-400 font-semibold">Nama Merchant: RAM PARFUM</p>
            </div>
        </div>

        <!-- Form Upload Bukti Transfer -->
        <form action="{{ route('order.uploadProof') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">

            <div class="space-y-1">
                <label class="block text-xs text-zinc-400 font-bold uppercase">Upload Bukti Transfer / Pembayaran</label>
                <input type="file" name="proof_image" required class="w-full text-sm text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-zinc-800 file:text-amber-400 hover:file:bg-zinc-700 cursor-pointer bg-zinc-950 p-2 rounded-xl border border-zinc-700">
                <p class="text-[10px] text-zinc-500">Format yang didukung: JPG, JPEG, PNG (Maks. 2MB)</p>
            </div>

            <button type="submit" class="w-full gold-bg text-zinc-950 font-bold py-3 rounded-xl hover:bg-amber-400 transition shadow-lg">
                Kirim Bukti Pembayaran
            </button>
        </form>
    </div>
</div>

<!-- Script Interaktif Tombol QRIS -->
<script>
    document.getElementById('show-qris-btn').addEventListener('click', function () {
        const qrisContainer = document.getElementById('qris-container');
        qrisContainer.classList.toggle('hidden');
        if (!qrisContainer.classList.contains('hidden')) {
            this.innerHTML = '<i class="fa-solid fa-eye-slash text-amber-400"></i> Sembunyikan Kode QRIS';
        } else {
            this.innerHTML = '<i class="fa-solid fa-eye text-amber-400"></i> Klik untuk Munculkan Kode QRIS';
        }
    });
</script>
@endsection