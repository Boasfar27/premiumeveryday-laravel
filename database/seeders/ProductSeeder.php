<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get category IDs
        $electronics = Category::where('slug', 'electronics')->first()->id;
        $clothing = Category::where('slug', 'clothing')->first()->id;
        $homeKitchen = Category::where('slug', 'home-kitchen')->first()->id;
        $beauty = Category::where('slug', 'beauty-personal-care')->first()->id;
        $sports = Category::where('slug', 'sports-outdoors')->first()->id;

        $products = [
            [
                'name' => 'Premium Smartphone',
                'slug' => 'premium-smartphone',
                'description' => 'High-end smartphone with advanced features',
                'sharing_price' => 899.99,
                'private_price' => 999.99,
                'sharing_description' => 'Share this premium smartphone with friends',
                'private_description' => 'Exclusive private use of this premium smartphone',
                'price' => 899.99,
                'old_price' => 999.99,
                'stock' => 50,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $electronics,
                'order' => 1,
            ],
            [
                'name' => 'Wireless Earbuds',
                'slug' => 'wireless-earbuds',
                'description' => 'Premium wireless earbuds with noise cancellation',
                'sharing_price' => 149.99,
                'private_price' => 199.99,
                'sharing_description' => 'Share these wireless earbuds with friends',
                'private_description' => 'Exclusive private use of these wireless earbuds',
                'price' => 149.99,
                'old_price' => 199.99,
                'stock' => 100,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $electronics,
                'order' => 2,
            ],
            [
                'name' => 'Designer T-Shirt',
                'slug' => 'designer-t-shirt',
                'description' => 'Premium cotton t-shirt with designer print',
                'sharing_price' => 39.99,
                'private_price' => 49.99,
                'sharing_description' => 'Share this designer t-shirt with friends',
                'private_description' => 'Exclusive private use of this designer t-shirt',
                'price' => 39.99,
                'old_price' => 49.99,
                'stock' => 200,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => $clothing,
                'order' => 3,
            ],
            [
                'name' => 'Premium Jeans',
                'slug' => 'premium-jeans',
                'description' => 'High-quality denim jeans with perfect fit',
                'sharing_price' => 69.99,
                'private_price' => 89.99,
                'sharing_description' => 'Share these premium jeans with friends',
                'private_description' => 'Exclusive private use of these premium jeans',
                'price' => 69.99,
                'old_price' => 89.99,
                'stock' => 150,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $clothing,
                'order' => 4,
            ],
            [
                'name' => 'Smart Coffee Maker',
                'slug' => 'smart-coffee-maker',
                'description' => 'Wi-Fi enabled coffee maker with smartphone control',
                'sharing_price' => 99.99,
                'private_price' => 129.99,
                'sharing_description' => 'Share this smart coffee maker with friends',
                'private_description' => 'Exclusive private use of this smart coffee maker',
                'price' => 99.99,
                'old_price' => 129.99,
                'stock' => 75,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => $homeKitchen,
                'order' => 5,
            ],
            [
                'name' => 'Premium Cookware Set',
                'slug' => 'premium-cookware-set',
                'description' => 'Professional-grade stainless steel cookware set',
                'price' => 249.99,
                'old_price' => 299.99,
                'stock' => 30,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => $homeKitchen,
                'order' => 6,
            ],
            [
                'name' => 'Luxury Skincare Set',
                'slug' => 'luxury-skincare-set',
                'description' => 'Complete skincare routine with premium ingredients',
                'price' => 129.99,
                'old_price' => 149.99,
                'stock' => 60,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => $beauty,
                'order' => 7,
            ],
            [
                'name' => 'Premium Hair Dryer',
                'slug' => 'premium-hair-dryer',
                'description' => 'Professional-grade hair dryer with ionic technology',
                'price' => 149.99,
                'old_price' => 179.99,
                'stock' => 45,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => $beauty,
                'order' => 8,
            ],
            [
                'name' => 'Smart Fitness Watch',
                'slug' => 'smart-fitness-watch',
                'description' => 'Advanced fitness tracker with heart rate monitoring',
                'price' => 169.99,
                'old_price' => 199.99,
                'stock' => 80,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => $sports,
                'order' => 9,
            ],
            [
                'name' => 'Premium Yoga Mat',
                'slug' => 'premium-yoga-mat',
                'description' => 'Eco-friendly yoga mat with superior grip',
                'price' => 59.99,
                'old_price' => 79.99,
                'stock' => 120,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => $sports,
                'order' => 10,
            ],
        ];

        foreach ($products as $productData) {
            if (!Product::where('slug', $productData['slug'])->exists()) {
                Product::create($productData);
            }
        }
    }
}
