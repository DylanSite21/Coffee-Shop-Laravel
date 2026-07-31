<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $coffeeMenus = [
            ['name' => 'Espresso',          'price' => 15000, 'description' => 'Kopi hitam pekat dengan crema sempurna, diseduh dari biji pilihan robusta Flores. Rasa kuat dan bold untuk pecinta kopi sejati.', 'status' => 'approved'],
            ['name' => 'Americano',          'price' => 18000, 'description' => 'Espresso double shot yang diencerkan dengan air panas berkualitas. Rasa bersih dan clean, cocok untuk dinikmati sepanjang hari.', 'status' => 'approved'],
            ['name' => 'Cappuccino',         'price' => 22000, 'description' => 'Kombinasi espresso, susu kukus, dan microfoam lembut dalam porsi seimbang. Klasik yang tak pernah salah, dengan sedikit taburan bubuk coklat.', 'status' => 'approved'],
            ['name' => 'Cafe Latte',         'price' => 23000, 'description' => 'Espresso dengan susu kukus yang creamy dan lembut. Tekstur smooth dan rasa yang ringan, pilihan populer di Kopi Nusantara.', 'status' => 'approved'],
            ['name' => 'Caramel Macchiato', 'price' => 28000, 'description' => 'Lapisan vanilla syrup, susu kukus, espresso, dan drizzle karamel manis. Perpaduan sempurna antara manis dan pahit yang memanjakan lidah.', 'status' => 'approved'],
            ['name' => 'Mocha',             'price' => 26000, 'description' => 'Espresso bertemu coklat Belgian premium dengan susu kukus. Sensasi bittersweet yang kaya, cocok untuk pecinta coklat dan kopi.', 'status' => 'approved'],
            ['name' => 'Vanilla Latte',     'price' => 25000, 'description' => 'Latte premium dengan sentuhan vanilla Madagascar yang lembut dan wangi. Manis alami yang menenangkan, pilihan favorit pelanggan setia kami.', 'status' => 'approved'],
        ];

        $nonCoffeeMenus = [
            ['name' => 'Matcha Latte',      'price' => 25000, 'description' => 'Matcha grade ceremonial asal Uji, Jepang, disajikan dengan susu full cream hangat. Aroma rumput segar dengan rasa umami yang khas.', 'status' => 'approved'],
            ['name' => 'Chocolate Latte',   'price' => 24000, 'description' => 'Coklat Belgia 70% cacao dilarutkan dalam susu kukus panas. Rich, creamy, dan penuh dengan citarasa coklat yang autentik.', 'status' => 'approved'],
            ['name' => 'Red Velvet Latte',  'price' => 26000, 'description' => 'Perpaduan susu kukus dengan red velvet syrup yang beraroma khas. Berwarna merah cantik dengan rasa yang unik dan menggugah selera.', 'status' => 'approved'],
            ['name' => 'Taro Latte',        'price' => 25000, 'description' => 'Kelembutan talas ungu asli dipadukan dengan susu segar berkualitas. Minuman berwarna ungu cantik dengan rasa yang creamy dan sedikit manis.', 'status' => 'approved'],
            ['name' => 'Thai Tea',          'price' => 20000, 'description' => 'Teh Ceylon pilihan yang diseduh kuat, disajikan dingin dengan susu evaporated. Resep tradisional Thailand yang menyegarkan dan autentik.', 'status' => 'approved'],
            ['name' => 'Peach Tea',         'price' => 18000, 'description' => 'Teh hitam segar dipadukan dengan sirup persik yang manis dan harum. Minuman dingin yang sempurna untuk melepas dahaga di hari yang panas.', 'status' => 'approved'],
            ['name' => 'Lemon Tea',         'price' => 17000, 'description' => 'Teh hitam berkualitas dengan perasan lemon segar dan sedikit madu. Segar, ringan, dan kaya vitamin C. Minuman favorit untuk hari-hari aktifmu.', 'status' => 'approved'],
        ];

        $pastryMenus = [
            ['name' => 'Butter Croissant',      'price' => 18000, 'description' => 'Croissant dengan lapisan mentega Prancis yang renyah di luar, lembut di dalam. Dipanggang segar setiap pagi oleh pastry chef kami.', 'status' => 'approved'],
            ['name' => 'Chocolate Croissant',   'price' => 22000, 'description' => 'Pain au Chocolat klasik dengan isian dark chocolate Valrhona yang meleleh sempurna. Pasangan ideal untuk secangkir espresso pagi hari.', 'status' => 'approved'],
            ['name' => 'Cinnamon Roll',         'price' => 20000, 'description' => 'Roti gulung kayu manis yang lembut dengan lapisan cream cheese frosting yang creamy. Hangat dan wangi, seperti buatan rumah sendiri.', 'status' => 'approved'],
            ['name' => 'Cheese Danish',         'price' => 19000, 'description' => 'Pastry lapis dengan isian krim keju yang lembut dan sedikit asam. Tekstur flaky dengan rasa gurih manis yang seimbang dan memanjakan.', 'status' => 'approved'],
            ['name' => 'Blueberry Muffin',      'price' => 16000, 'description' => 'Muffin lembab dengan biji blueberry segar yang meledak di mulut. Ditaburi crumble gula di atasnya untuk tekstur extra yang memikat.', 'status' => 'approved'],
            ['name' => 'Banana Cake',           'price' => 21000, 'description' => 'Kue pisang home-style dengan pisang cavendish matang pilihan. Lembab, wangi, dan tidak terlalu manis — cocok menemani kopi hangat Anda.', 'status' => 'approved'],
        ];

        $snackMenus = [
            ['name' => 'French Fries',    'price' => 15000, 'description' => 'Kentang goreng renyah keemasan dengan taburan garam laut dan parsley. Disajikan hangat dengan saus tomat dan mayonnaise spesial kami.', 'status' => 'approved'],
            ['name' => 'Loaded Fries',    'price' => 25000, 'description' => 'French fries premium disiram saus keju cheddar leleh, ditaburi bacon bits, jalapeño, dan daun bawang. Ultimate comfort food yang bikin nagih.', 'status' => 'approved'],
            ['name' => 'Cheese Fries',    'price' => 20000, 'description' => 'Kentang goreng renyah yang disiram saus nacho cheese panas meleleh. Gurih, cheesy, dan sangat satisfying — snack terfavorit di menu kami.', 'status' => 'approved'],
            ['name' => 'Onion Rings',     'price' => 18000, 'description' => 'Bawang bombay manis dibalut tepung berbumbu spesial dan digoreng crispy. Disajikan dengan saus ranch homemade yang creamy dan beraroma herb.', 'status' => 'approved'],
            ['name' => 'Chicken Nuggets', 'price' => 22000, 'description' => 'Potongan ayam dada pilihan yang dibalut breadcrumb renyah. Digoreng golden brown, disajikan dengan saus BBQ smoky dan honey mustard.', 'status' => 'approved'],
        ];

        $cookieMenus = [
            ['name' => 'Chocolate Chip Cookies',   'price' => 12000, 'description' => 'Cookies klasik dengan adonan mentega pilihan dan chocolate chips premium. Sisi luar sedikit crispy, bagian dalam tetap chewy dan gooey — sempurna!', 'status' => 'approved'],
            ['name' => 'Double Chocolate Cookies', 'price' => 14000, 'description' => 'Cookies coklat intensitas tinggi dengan cocoa powder dan dark chocolate chunks. Untuk pecinta coklat sejati, ini adalah surga dalam satu gigitan.', 'status' => 'approved'],
            ['name' => 'Matcha Cookies',           'price' => 15000, 'description' => 'Cookies dengan matcha premium Jepang yang memberikan warna hijau cantik dan rasa earthy khas. Paduan sempurna antara manis dan pahit.', 'status' => 'approved'],
            ['name' => 'Red Velvet Cookies',       'price' => 16000, 'description' => 'Cookies berwarna merah menawan dengan cream cheese chips di dalamnya. Rasa sedikit tangy dari cream cheese membuatnya unik dan tak terlupakan.', 'status' => 'approved'],
            ['name' => 'Butter Cookies',           'price' => 10000, 'description' => 'Cookies mentega tradisional yang renyah dengan tekstur yang melt-in-your-mouth. Resep klasik yang sederhana namun tetap menjadi favorit semua usia.', 'status' => 'approved'],
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

        $adminId = \App\Models\User::where('email', 'admin@coffeeshop.test')->first()?->id;

        foreach ($menus as $menu) {
            Menu::updateOrCreate(
                ['name' => $menu['name'], 'category_id' => $category->id],
                array_merge($menu, ['category_id' => $category->id, 'is_available' => true, 'user_id' => $adminId])
            );
        }
    }
}

