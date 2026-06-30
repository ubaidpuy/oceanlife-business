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
        Admin::create([
            'name' => 'Shop Owner',
            'email' => 'admin@oceanlife.com',
            'password' => 'password',
        ]);

        Setting::create([
            'shop_name' => 'Ocean Life',
            'address' => '123 Ocean Avenue, Coastal City',
            'phone' => '+1 234 567 8900',
            'whatsapp' => '+1 234 567 8900',
            'email' => 'hello@oceanlife.com',
            'facebook' => 'https://facebook.com/oceanlife',
            'instagram' => 'https://instagram.com/oceanlife',
            'about_us' => 'Ocean Life is your premier destination for aquarium supplies, exotic fish, and everything you need to create a thriving underwater world. We are passionate about marine life and committed to helping you build beautiful aquatic ecosystems.',
            'shipping_policy' => 'We ship nationwide within 3-7 business days. Free shipping on orders over $100. All live fish are shipped with care using temperature-controlled packaging.',
        ]);

        $categories = [
            'Aquariums',
            'Fish',
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
            ['Betta Splendens - Blue', 'Fish', 12.99, null, 5.00, true],
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
