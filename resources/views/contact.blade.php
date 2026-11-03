@extends('layouts.app')

@section('title', 'Hubungi Toko - RAM Parfum')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-16 space-y-8">
    <div class="text-center space-y-3">
        <h1 class="text-3xl font-bold">Hubungi Tim RAM Parfum</h1>
        <p class="text-zinc-400">Pilih layanan bantuan yang kamu butuhkan langsung via WhatsApp resmi kami.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Kartu 1: Konsultasi Aroma -->
        <div class="bg-zinc-900 border border-zinc-800 p-8 rounded-2xl space-y-4 text-center hover:border-amber-500/50 transition">
            <div class="w-16 h-16 gold-bg rounded-full flex items-center justify-center mx-auto text-zinc-950 text-2xl">
                <i class="fa-solid fa-comments"></i>
            </div>
            <h3 class="text-xl font-bold">Konsultasi Varian Aroma</h3>
            <p class="text-sm text-zinc-400">Bingung memilih varian rasa/aroma parfum yang cocok dengan aktivitas dan kepribadianmu? Konsultasikan gratis bersama kami.</p>
            <a href="https://wa.me/6287740908811?text=Halo%20Admin%20RAM%20Parfum,%20saya%20ingin%20konsultasi%20pilihan%20aroma%20parfum" target="_blank" class="inline-block w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3 rounded-xl transition">
                <i class="fa-brands fa-whatsapp mr-2"></i> Chat Admin Konsultasi
            </a>
        </div>

        <!-- Kartu 2: Menjual Parfum -->
        <div class="bg-zinc-900 border border-zinc-800 p-8 rounded-2xl space-y-4 text-center hover:border-amber-500/50 transition">
            <div class="w-16 h-16 bg-amber-500 rounded-full flex items-center justify-center mx-auto text-zinc-950 text-2xl">
                <i class="fa-solid fa-hand-holding-dollar"></i>
            </div>
            <h3 class="text-xl font-bold">Ingin Menjual Parfum?</h3>
            <p class="text-sm text-zinc-400">Punya koleksi parfum original yang ingin kamu jual kembali ke RAM Parfum? Hubungi tim appraisal/pembelian kami.</p>
            <a href="https://wa.me/6287740908811?text=Halo%20Admin%20RAM%20Parfum,%20saya%20ingin%20menjual%20parfum%20koleksi%20saya" target="_blank" class="inline-block w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3 rounded-xl transition">
                <i class="fa-brands fa-whatsapp mr-2"></i> Chat Penawaran Jual
            </a>
        </div>
    </div>
</div>
@endsection