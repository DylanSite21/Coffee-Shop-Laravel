<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Coffee', 'slug' => 'coffee', 'description' => 'Various coffee drinks', 'is_active' => true],
            ['name' => 'Non Coffee', 'slug' => 'non-coffee', 'description' => 'Delicious non-coffee beverages', 'is_active' => true],
            ['name' => 'Pastry', 'slug' => 'pastry', 'description' => 'Fresh pastries and baked goods', 'is_active' => true],
            ['name' => 'Snacks', 'slug' => 'snacks', 'description' => 'Quick and tasty snacks', 'is_active' => true],
            ['name' => 'Cookies', 'slug' => 'cookies', 'description' => 'Homemade cookies', 'is_active' => true],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
