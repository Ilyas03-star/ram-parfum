<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private function checkAdmin()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(redirect()->route('home')->with('error', 'Akses ditolak!'));
        }
    }

    public function index()
    {
        fax: $this->checkAdmin();
        $products = Product::with('variants')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $this->checkAdmin();
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $this->checkAdmin();

        $request->validate([
            'name' => 'required',
            'category' => 'required', // Validasi input kategori manual
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'variants' => 'required|array|min:1',
            'variants.*.size' => 'required',
            'variants.*.price' => 'required|numeric',
            'variants.*.stock' => 'required|numeric',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $filename);
            $imagePath = 'uploads/products/' . $filename;
        }

        // Simpan produk utama beserta kategori teks manual
        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category' => $request->category, // <-- Pastikan baris ini ada
            'price' => $request->variants[0]['price'],
            'stock' => collect($request->variants)->sum('stock'),
            'size' => $request->variants[0]['size'],
            'scent_notes' => $request->scent_notes ?? '-',
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        // Simpan varian ukuran
        foreach ($request->variants as $variant) {
            $product->variants()->create([
                'size' => $variant['size'],
                'price' => $variant['price'],
                'stock' => $variant['stock'],
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk dan opsi ukuran berhasil ditambahkan!');
    }
    public function destroy($id)
    {
        $this->checkAdmin();

        $product = Product::findOrFail($id);

        // Hapus file foto produk jika ada
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        // Hapus data varian terkait dan produk utama
        $product->variants()->delete();
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk dan variannya berhasil dihapus!');
    }
    public function edit($id)
    {
        $this->checkAdmin();
        $product = Product::with('variants')->findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $this->checkAdmin();

        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'variants' => 'required|array|min:1',
            'variants.*.size' => 'required',
            'variants.*.price' => 'required|numeric',
            'variants.*.stock' => 'required|numeric',
        ]);

        $product = Product::findOrFail($id);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $filename);
            $imagePath = 'uploads/products/' . $filename;
        }

        // Perbarui data produk utama
        $product->update([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'category' => $request->category,
            'price' => $request->variants[0]['price'],
            'stock' => collect($request->variants)->sum('stock'),
            'size' => $request->variants[0]['size'],
            'scent_notes' => $request->scent_notes ?? '-',
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        // Hapus varian lama, lalu masukkan varian yang baru diperbarui
        $product->variants()->delete();
        foreach ($request->variants as $variant) {
            $product->variants()->create([
                'size' => $variant['size'],
                'price' => $variant['price'],
                'stock' => $variant['stock'],
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk dan variannya berhasil diperbarui!');
    }
}