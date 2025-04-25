<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['image_path'];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_image_id');
    }
}
