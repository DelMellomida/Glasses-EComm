<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductImage;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        $productImages = [
            [
                'product_id' => 1,
                'image_path' => 'https://res.cloudinary.com/dckv0ylzi/image/upload/v1748528447/products/product1zAikS/unmzh9dgxu9eot0hqqu8.jpg',
                'cloudinary_public_id' => 'products/product1zAikS/unmzh9dgxu9eot0hqqu8',
                'public_id' => 'products/product1zAikS',
            ],
            [
                'product_id' => 2,
                'image_path' => 'https://res.cloudinary.com/dckv0ylzi/image/upload/v1748528497/products/product28kqMg/tvjosyzj5dcphwcjunu4.jpg',
                'cloudinary_public_id' => 'products/product28kqMg/tvjosyzj5dcphwcjunu4',
                'public_id' => 'products/product28kqMg',
            ],
            [
                'product_id' => 3,
                'image_path' => 'https://res.cloudinary.com/dckv0ylzi/image/upload/v1748528552/products/product38RRIB/wnzqdzftqmuvqt8qrsnu.jpg',
                'cloudinary_public_id' => 'products/product38RRIB/wnzqdzftqmuvqt8qrsnu',
                'public_id' => 'products/product38RRIB',
            ],
        ];

        foreach ($productImages as $image) {
            ProductImage::create($image);
        }
    }
}
