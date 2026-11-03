<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category', // Diubah dari category_id menjadi category (teks manual)
        'name', 
        'slug', 
        'description', 
        'scent_notes', 
        'price', 
        'stock', 
        'size', 
        'image'
    ];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}