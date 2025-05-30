<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'category_name' => 'Graded Eyeglass',
                'category_desc' => 'Just your typical eyeglass',
                'availability_type' => 'on-branch',
            ],
            [
                'category_name' => 'Contact Lens',
                'category_desc' => 'Contact lens for your eyes',
                'availability_type' => 'online',
            ],
            [
                'category_name' => 'Fashion Eyeglass',
                'category_desc' => 'Fashionable eyeglass for your style',
                'availability_type' => 'online',
            ]

        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
