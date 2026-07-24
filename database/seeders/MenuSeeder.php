<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $coffeeMenus = [
            ['name' => 'Espresso', 'price' => 15000, 'description' => 'Strong black coffee', 'status' => 'approved'],
            ['name' => 'Americano', 'price' => 18000, 'description' => 'Coffee with hot water', 'status' => 'approved'],
            ['name' => 'Cappuccino', 'price' => 22000, 'description' => 'Coffee with steamed milk foam', 'status' => 'approved'],
            ['name' => 'Cafe Latte', 'price' => 23000, 'description' => 'Coffee with steamed milk', 'status' => 'approved'],
            ['name' => 'Caramel Macchiato', 'price' => 28000, 'description' => 'Coffee with caramel and milk', 'status' => 'approved'],
            ['name' => 'Mocha', 'price' => 26000, 'description' => 'Coffee with chocolate', 'status' => 'approved'],
            ['name' => 'Vanilla Latte', 'price' => 25000, 'description' => 'Coffee with vanilla and milk', 'status' => 'approved'],
        ];

        $nonCoffeeMenus = [
            ['name' => 'Matcha Latte', 'price' => 25000, 'description' => 'Japanese green tea with milk', 'status' => 'approved'],
            ['name' => 'Chocolate Latte', 'price' => 24000, 'description' => 'Rich chocolate with milk', 'status' => 'approved'],
            ['name' => 'Red Velvet Latte', 'price' => 26000, 'description' => 'Red velvet flavored latte', 'status' => 'approved'],
            ['name' => 'Taro Latte', 'price' => 25000, 'description' => 'Taro root flavored latte', 'status' => 'approved'],
            ['name' => 'Thai Tea', 'price' => 20000, 'description' => 'Traditional Thai iced tea', 'status' => 'approved'],
            ['name' => 'Peach Tea', 'price' => 18000, 'description' => 'Refreshing peach tea', 'status' => 'approved'],
            ['name' => 'Lemon Tea', 'price' => 17000, 'description' => 'Fresh lemon tea', 'status' => 'approved'],
        ];

        $pastryMenus = [
            ['name' => 'Butter Croissant', 'price' => 18000, 'description' => 'Flaky buttery croissant', 'status' => 'approved'],
            ['name' => 'Chocolate Croissant', 'price' => 22000, 'description' => 'Croissant filled with chocolate', 'status' => 'approved'],
            ['name' => 'Cinnamon Roll', 'price' => 20000, 'description' => 'Sweet cinnamon roll with icing', 'status' => 'approved'],
            ['name' => 'Cheese Danish', 'price' => 19000, 'description' => 'Danish pastry with cheese', 'status' => 'approved'],
            ['name' => 'Blueberry Muffin', 'price' => 16000, 'description' => 'Moist blueberry muffin', 'status' => 'approved'],
            ['name' => 'Banana Cake', 'price' => 21000, 'description' => 'Moist banana cake slice', 'status' => 'approved'],
        ];

        $snackMenus = [
            ['name' => 'French Fries', 'price' => 15000, 'description' => 'Classic golden french fries', 'status' => 'approved'],
            ['name' => 'Loaded Fries', 'price' => 25000, 'description' => 'Fries with cheese and toppings', 'status' => 'approved'],
            ['name' => 'Cheese Fries', 'price' => 20000, 'description' => 'Fries covered in melted cheese', 'status' => 'approved'],
            ['name' => 'Onion Rings', 'price' => 18000, 'description' => 'Crispy onion rings', 'status' => 'approved'],
            ['name' => 'Chicken Nuggets', 'price' => 22000, 'description' => 'Crispy chicken nuggets', 'status' => 'approved'],
        ];

        $cookieMenus = [
            ['name' => 'Chocolate Chip Cookies', 'price' => 12000, 'description' => 'Classic chocolate chip cookies', 'status' => 'approved'],
            ['name' => 'Double Chocolate Cookies', 'price' => 14000, 'description' => 'Cookies with double chocolate', 'status' => 'approved'],
            ['name' => 'Matcha Cookies', 'price' => 15000, 'description' => 'Japanese matcha cookies', 'status' => 'approved'],
            ['name' => 'Red Velvet Cookies', 'price' => 16000, 'description' => 'Red velvet flavored cookies', 'status' => 'approved'],
            ['name' => 'Butter Cookies', 'price' => 10000, 'description' => 'Traditional butter cookies', 'status' => 'approved'],
        ];

        $this->insertMenus($coffeeMenus, 'coffee');
        $this->insertMenus($nonCoffeeMenus, 'non-coffee');
        $this->insertMenus($pastryMenus, 'pastry');
        $this->insertMenus($snackMenus, 'snacks');
        $this->insertMenus($cookieMenus, 'cookies');
    }

    private function insertMenus(array $menus, string $categorySlug): void
    {
        $category = \App\Models\Category::where('slug', $categorySlug)->first();

        if (!$category) {
            return;
        }

        $adminId = \App\Models\User::where('email', 'admin@gmail.com')->first()?->id;

        foreach ($menus as $menu) {
            Menu::updateOrCreate(
                ['name' => $menu['name'], 'category_id' => $category->id],
                array_merge($menu, ['category_id' => $category->id, 'is_available' => true, 'user_id' => $adminId])
            );
        }
    }
}
