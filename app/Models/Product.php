<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'product_image_id',
    ];

    public function image()
    {
        return $this->belongsTo(ProductImage::class, 'product_image_id');
    }
}
