<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'product_name' => 'Female Graded Eyeglass',
                'product_description' => 'Just your typical female graded eyeglass',
                'price' => 1499,
                'stock' => 100,
                'gender' => 'female',
                'status' => 'active',
                'category_id' => 1,
            ],
            [
                'product_name' => 'Male Graded Eyeglass',
                'product_description' => 'Just your typical male graded eyeglass',
                'price' => 1499,
                'stock' => 100,
                'gender' => 'male',
                'status' => 'active',
                'category_id' => 1,
            ],
            [
                'product_name' => 'Unisex Fashion Eyeglass',
                'product_description' => 'Just your typical unisex fashion eyeglass',
                'price' => 1499,
                'stock' => 100,
                'gender' => 'unisex',
                'status' => 'active',
                'category_id' => 1,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
