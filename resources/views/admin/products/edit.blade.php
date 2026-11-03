@extends('layouts.app')

@section('title', 'Edit Produk Parfum - Admin RAM Parfum')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">
    <div class="bg-zinc-900 border border-zinc-800 p-8 rounded-2xl shadow-xl space-y-6">
        <h1 class="text-2xl font-bold text-zinc-100">Edit Produk Parfum</h1>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Nama Parfum -->
            <div>
                <label class="block text-xs text-zinc-400 mb-1 font-bold uppercase">Nama Parfum</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full bg-zinc-950 border border-zinc-700 rounded-lg p-3 text-sm text-zinc-200 focus:outline-none focus:border-amber-400">
            </div>

            <!-- Kategori (Teks Manual) -->
            <div>
                <label class="block text-xs text-zinc-400 mb-1 font-bold uppercase">Kategori Parfum</label>
                <input type="text" name="category" value="{{ old('category', $product->category) }}" required class="w-full bg-zinc-950 border border-zinc-700 rounded-lg p-3 text-sm text-zinc-200 focus:outline-none focus:border-amber-400" placeholder="Contoh: Parfum Pria / Gourmand">
            </div>

            <!-- Bagian Opsi Varian Ukuran, Harga, & Stok -->
            <div class="space-y-3 bg-zinc-950 p-5 rounded-xl border border-zinc-800">
                <div class="flex items-center justify-between">
                    <label class="text-xs text-amber-400 font-bold uppercase tracking-wider"><i class="fa-solid fa-boxes-stacked mr-1"></i> Pilihan Ukuran Botol, Harga & Stok</label>
                    <button type="button" id="add-variant-btn" class="bg-zinc-800 hover:bg-zinc-700 text-amber-400 text-xs font-bold px-3 py-1.5 rounded-lg transition">
                        + Tambah Ukuran Lain
                    </button>
                </div>

                <div id="variants-container" class="space-y-3">
                    @foreach($product->variants as $index => $variant)
                    <div class="variant-row grid grid-cols-1 md:grid-cols-3 gap-3 items-center bg-zinc-900 p-3 rounded-lg border border-zinc-800 relative">
                        <div>
                            <span class="block text-[10px] text-zinc-400 mb-1">Ukuran Botol</span>
                            <input type="text" name="variants[{{ $index }}][size]" value="{{ $variant->size }}" required class="w-full bg-zinc-950 border border-zinc-700 rounded-lg p-2 text-sm text-zinc-200 focus:outline-none focus:border-amber-400">
                        </div>
                        <div>
                            <span class="block text-[10px] text-zinc-400 mb-1">Harga (Rp)</span>
                            <input type="number" name="variants[{{ $index }}][price]" value="{{ $variant->price }}" required class="w-full bg-zinc-950 border border-zinc-700 rounded-lg p-2 text-sm text-zinc-200 focus:outline-none focus:border-amber-400">
                        </div>
                        <div class="flex items-end gap-2">
                            <div class="flex-1">
                                <span class="block text-[10px] text-zinc-400 mb-1">Stok</span>
                                <input type="number" name="variants[{{ $index }}][stock]" value="{{ $variant->stock }}" required class="w-full bg-zinc-950 border border-zinc-700 rounded-lg p-2 text-sm text-zinc-200 focus:outline-none focus:border-amber-400">
                            </div>
                            @if($index > 0)
                            <button type="button" class="remove-row bg-red-900/50 hover:bg-red-600 text-red-200 text-xs px-3 py-2.5 rounded-lg transition self-end">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Ciri Aroma / Notes -->
            <div>
                <label class="block text-xs text-zinc-400 mb-1 font-bold uppercase">Ciri Aroma / Notes</label>
                <input type="text" name="scent_notes" value="{{ old('scent_notes', $product->scent_notes) }}" class="w-full bg-zinc-950 border border-zinc-700 rounded-lg p-3 text-sm text-zinc-200 focus:outline-none focus:border-amber-400">
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-xs text-zinc-400 mb-1 font-bold uppercase">Deskripsi Lengkap</label>
                <textarea name="description" required rows="3" class="w-full bg-zinc-950 border border-zinc-700 rounded-lg p-3 text-sm text-zinc-200 focus:outline-none focus:border-amber-400">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Upload Foto -->
            <div>
                <label class="block text-xs text-zinc-400 mb-1 font-bold uppercase">Ganti Foto Produk (Opsional)</label>
                <input type="file" name="image" class="w-full text-sm text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-zinc-800 file:text-amber-400 hover:file:bg-zinc-700 cursor-pointer">
                @if($product->image)
                    <p class="text-xs text-zinc-400 mt-2">Foto saat ini: <a href="{{ asset($product->image) }}" target="_blank" class="text-amber-400 underline">Lihat Foto</a></p>
                @endif
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="w-full gold-bg text-zinc-950 font-bold py-3 rounded-xl hover:bg-amber-400 transition shadow-lg">
                Perbarui Produk & Varian
            </button>
        </form>
    </div>
</div>

<!-- Script untuk tambah baris ukuran secara dinamis di halaman edit -->
<script>
    let variantIndex = {{ count($product->variants) }};
    document.getElementById('add-variant-btn').addEventListener('click', function () {
        const container = document.getElementById('variants-container');
        const row = document.createElement('div');
        row.className = 'variant-row grid grid-cols-1 md:grid-cols-3 gap-3 items-center bg-zinc-900 p-3 rounded-lg border border-zinc-800 relative';
        row.innerHTML = `
            <div>
                <span class="block text-[10px] text-zinc-400 mb-1">Ukuran Botol</span>
                <input type="text" name="variants[${variantIndex}][size]" required placeholder="Contoh: 50 ml" class="w-full bg-zinc-950 border border-zinc-700 rounded-lg p-2 text-sm text-zinc-200 focus:outline-none focus:border-amber-400">
            </div>
            <div>
                <span class="block text-[10px] text-zinc-400 mb-1">Harga (Rp)</span>
                <input type="number" name="variants[${variantIndex}][price]" required placeholder="Contoh: 200000" class="w-full bg-zinc-950 border border-zinc-700 rounded-lg p-2 text-sm text-zinc-200 focus:outline-none focus:border-amber-400">
            </div>
            <div class="flex items-end gap-2">
                <div class="flex-1">
                    <span class="block text-[10px] text-zinc-400 mb-1">Stok</span>
                    <input type="number" name="variants[${variantIndex}][stock]" required placeholder="Contoh: 15" class="w-full bg-zinc-950 border border-zinc-700 rounded-lg p-2 text-sm text-zinc-200 focus:outline-none focus:border-amber-400">
                </div>
                <button type="button" class="remove-row bg-red-900/50 hover:bg-red-600 text-red-200 text-xs px-3 py-2.5 rounded-lg transition self-end">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
        variantIndex++;

        row.querySelector('.remove-row').addEventListener('click', function () {
            row.remove();
        });
    });

    // Event listener untuk tombol hapus pada baris awal jika ada lebih dari 1
    document.querySelectorAll('.remove-row').forEach(button => {
        button.addEventListener('click', function () {
            button.closest('.variant-row').remove();
        });
    });
</script>
@endsection