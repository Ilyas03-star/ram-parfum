@extends('layouts.app')

@section('title', 'Daftar Akun Pembeli - RAM Parfum')

@section('content')
<div class="max-w-md mx-auto px-4 py-16">
    <div class="bg-zinc-900 border border-zinc-800 p-8 rounded-2xl space-y-6">
        <h2 class="text-2xl font-bold text-center">Daftar Akun Pembeli</h2>

        <form action="{{ route('register.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs text-zinc-400 mb-1">Nama Lengkap</label>
                <input type="text" name="name" required class="w-full bg-zinc-950 border border-zinc-700 rounded-lg p-2.5 text-sm text-zinc-200">
            </div>
            <div>
                <label class="block text-xs text-zinc-400 mb-1">Alamat Email</label>
                <input type="email" name="email" required class="w-full bg-zinc-950 border border-zinc-700 rounded-lg p-2.5 text-sm text-zinc-200">
            </div>
            <div>
                <label class="block text-xs text-zinc-400 mb-1">Nomor WhatsApp / Phone</label>
                <input type="text" name="phone" required class="w-full bg-zinc-950 border border-zinc-700 rounded-lg p-2.5 text-sm text-zinc-200">
            </div>
            <div>
                <label class="block text-xs text-zinc-400 mb-1">Password</label>
                <input type="password" name="password" required class="w-full bg-zinc-950 border border-zinc-700 rounded-lg p-2.5 text-sm text-zinc-200">
            </div>
            <button type="submit" class="w-full gold-bg text-zinc-950 font-bold py-3 rounded-xl hover:bg-amber-400 transition">
                Daftar Sekarang
            </button>
        </form>
    </div>
</div>
@endsection