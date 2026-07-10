<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate([
            'email' => env('ADMIN_EMAIL', 'admin@oceanlife.test'),
        ], [
            'name' => 'Shop Owner',
            'password' => env('ADMIN_PASSWORD', Str::password(16)),
        ]);

        Setting::updateOrCreate([], [
            'shop_name' => 'Ocean Life',
            'address' => null,
            'phone' => env('SHOP_PHONE'),
            'whatsapp' => env('SHOP_WHATSAPP'),
            'email' => env('SHOP_EMAIL'),
            'facebook' => env('SHOP_FACEBOOK'),
            'instagram' => env('SHOP_INSTAGRAM'),
            'about_us' => 'Ocean Life offers aquarium accessories, food, filters, lighting, plants, and care essentials for pet fish owners who want cleaner, healthier tanks.',
            'shipping_policy' => 'We ship aquarium accessories and care supplies nationwide within 3-7 business days. Free shipping thresholds and delivery timelines can be configured from the admin settings.',
        ]);

        $categories = [
            'Aquariums',
            'Fish Care',
            'Food',
            'Accessories',
            'Lights',
            'Plants',
            'Filters',
            'Medicines',
        ];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'status' => true,
            ]);
        }

        $sampleProducts = [
            ['Glass Aquarium 50L', 'Aquariums', 149.99, 129.99, 15.00, true],
            ['Aquarium Starter Care Kit', 'Fish Care', 24.99, null, 5.00, true],
            ['Tropical Fish Flakes 200g', 'Food', 8.99, null, 3.00, false],
            ['Aquarium Gravel - Natural', 'Accessories', 14.99, 11.99, 8.00, false],
            ['LED Aquarium Light 24"', 'Lights', 45.99, null, 6.00, true],
            ['Java Fern Live Plant', 'Plants', 9.99, null, 4.00, true],
            ['Canister Filter 300L/h', 'Filters', 79.99, 69.99, 10.00, true],
            ['Aquarium Water Conditioner', 'Medicines', 11.99, null, 3.00, false],
        ];

        foreach ($sampleProducts as [$name, $categoryName, $price, $discount, $shipping, $featured]) {
            $category = Category::where('name', $categoryName)->first();

            Product::create([
                'category_id' => $category->id,
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => "Premium quality {$name} for your aquarium. Carefully selected to ensure the health and beauty of your aquatic environment.",
                'price' => $price,
                'discount_price' => $discount,
                'shipping_charge' => $shipping,
                'stock' => rand(10, 100),
                'featured' => $featured,
                'status' => true,
            ]);
        }
    }
}
