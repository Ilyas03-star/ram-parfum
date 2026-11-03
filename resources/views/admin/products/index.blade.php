@extends('layouts.app')

@section('title', 'Kelola Produk - Admin RAM Parfum')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12 space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold">Manajemen Produk Parfum</h1>
        <a href="{{ route('admin.products.create') }}" class="gold-bg text-zinc-950 px-4 py-2.5 rounded-xl font-bold hover:bg-amber-400 transition">
            + Tambah Produk Baru
        </a>
    </div>

    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden shadow-xl">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-zinc-800 bg-zinc-950 text-zinc-400 text-xs uppercase">
                    <th class="p-4">Foto</th>
                    <th class="p-4">Nama Produk</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4">Harga</th>
                    <th class="p-4">Stok</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800 text-sm">
                @forelse($products as $product)
                    <tr>
                        <td class="p-4">
                            <div class="w-12 h-12 bg-zinc-800 rounded-lg overflow-hidden flex items-center justify-center">
                                @if($product->image)
                                    <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fa-solid fa-bottle-droplet gold-text"></i>
                                @endif
                            </div>
                        </td>
                        <td class="p-4 font-bold text-zinc-100">{{ $product->name }}</td>
                        <td class="p-4 text-amber-400">{{ $product->category }}</td>
                        <td class="p-4">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="p-4">{{ $product->stock }} {{ $product->size }}</td>
                        <td class="p-4 text-center space-x-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-zinc-800 hover:bg-zinc-700 text-amber-400 px-3 py-1.5 rounded-lg text-xs font-semibold">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-rose-950/50 hover:bg-rose-900 text-rose-400 px-3 py-1.5 rounded-lg text-xs font-semibold border border-rose-800">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-zinc-500">Belum ada produk tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection