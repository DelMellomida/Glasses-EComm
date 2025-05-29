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
                'category_name' => 'Eyeglass',
                'category_desc' => 'Eyeglass',
                'availability_type' => 'on-branch',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
