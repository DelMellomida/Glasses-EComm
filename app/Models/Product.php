<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;

class Product extends Model
{
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_name',
        'product_description',
        'price',
        'category_id',
        'stock'
    ];
    public function images()
    {
        // Ensure the second parameter matches the foreign key column in product_images table
        return $this->hasMany(ProductImage::class, 'product_id', 'product_id');
    }
}
