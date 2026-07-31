<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Coffee',    'slug' => 'coffee',     'description' => 'Kopi espresso & signature',  'is_active' => true],
            ['name' => 'Non Coffee','slug' => 'non-coffee', 'description' => 'Minuman tanpa kopi',           'is_active' => true],
            ['name' => 'Pastry',    'slug' => 'pastry',     'description' => 'Kue & roti panggang segar',    'is_active' => true],
            ['name' => 'Snacks',    'slug' => 'snacks',     'description' => 'Camilan lezat & gurih',        'is_active' => true],
            ['name' => 'Cookies',   'slug' => 'cookies',    'description' => 'Cookies homemade special',     'is_active' => true],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
