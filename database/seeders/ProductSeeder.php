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
                'product_name' => 'Female Eyeglass',
                'product_description' => 'Just your typical female eyeglass',
                'price' => 1499,
                'stock' => 100,
                'gender' => 'female',
                'status' => 'active',
                'category_id' => 1,
            ],
            [
                'product_name' => 'Male Eyeglass',
                'product_description' => 'Just your typical male eyeglass',
                'price' => 1499,
                'stock' => 100,
                'gender' => 'male',
                'status' => 'active',
                'category_id' => 1,
            ],
            [
                'product_name' => 'Unisex Eyeglass',
                'product_description' => 'Just your typical unisex eyeglass',
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
