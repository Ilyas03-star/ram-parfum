<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Default
        User::create([
            'name' => 'Admin RAM Parfum',
            'email' => 'admin@ramparfum.com',
            'password' => Hash::make('admin123'),
            'phone' => '081234567890',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Budi Pembeli',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('pembeli123'),
            'phone' => '089876543210',
            'role' => 'pembeli',
        ]);

        // 2. Kategori Parfum
        $catPria = Category::create(['name' => 'Parfum Pria', 'slug' => 'parfum-pria']);
        $catWanita = Category::create(['name' => 'Parfum Wanita', 'slug' => 'parfum-wanita']);
        $catUnisex = Category::create(['name' => 'Parfum Unisex', 'slug' => 'parfum-unisex']);

        // 3. Produk Parfum dengan Gambar Unsplash
        Product::create([
            'category_id' => $catPria->id,
            'name' => 'RAM Royal Leather',
            'slug' => Str::slug('RAM Royal Leather'),
            'description' => 'Aroma kayu manis dan kulit mewah yang memberikan kesan maskulin, kuat, dan elegan sepanjang hari.',
            'scent_notes' => 'Top: Bergamot, Cinnamon | Middle: Leather, Tobacco | Base: Cedarwood, Amber',
            'price' => 285000,
            'stock' => 15,
            'size' => '100 ml',
            'image' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=500&q=80',
        ]);

        Product::create([
            'category_id' => $catWanita->id,
            'name' => 'RAM Vanilla Sweetness',
            'slug' => Str::slug('RAM Vanilla Sweetness'),
            'description' => 'Aroma manis lembut vanilla dipadukan dengan sentuhan bunga melati yang feminin dan menenangkan.',
            'scent_notes' => 'Top: Sweet Vanilla, Pear | Middle: Jasmine, Rose | Base: White Musk, Tonka Bean',
            'price' => 245000,
            'stock' => 20,
            'size' => '50 ml',
            'image' => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=500&q=80',
        ]);

        Product::create([
            'category_id' => $catUnisex->id,
            'name' => 'RAM Fresh Citrus Breeze',
            'slug' => Str::slug('RAM Fresh Citrus Breeze'),
            'description' => 'Kesegaran buah jeruk dan mint yang bikin semangat di siang hari. Cocok untuk pria maupun wanita aktif.',
            'scent_notes' => 'Top: Lemon, Mint, Orange | Middle: Green Tea, Lavender | Base: Vetiver, Musk',
            'price' => 195000,
            'stock' => 25,
            'size' => '60 ml',
            'image' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?w=500&q=80',
        ]);
    }
}