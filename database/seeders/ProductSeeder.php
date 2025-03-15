<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create products directory if it doesn't exist
        Storage::disk('public')->makeDirectory('products');

        $products = [
            [
                'name' => 'Premium Everyday Package A',
                'description' => 'Complete package for your daily needs',
                'sharing_price' => 299000,
                'private_price' => 399000,
                'sharing_description' => 'Perfect for sharing with friends - includes all basic items',
                'private_description' => 'Exclusive private package with premium items',
                'image' => 'products/package-a.jpg',
                'is_active' => true,
                'order' => 1,
                'sharing_discount' => 10,
                'private_discount' => 15,
                'is_promo' => true,
                'promo_ends_at' => now()->addDays(7),
            ],
            [
                'name' => 'Premium Everyday Package B',
                'description' => 'Enhanced package with additional items',
                'sharing_price' => 399000,
                'private_price' => 499000,
                'sharing_description' => 'Sharing package with premium features',
                'private_description' => 'Private package with exclusive benefits',
                'image' => 'products/package-b.jpg',
                'is_active' => true,
                'order' => 2,
                'sharing_discount' => 0,
                'private_discount' => 0,
                'is_promo' => false,
                'promo_ends_at' => null,
            ],
            [
                'name' => 'Premium Everyday Package C',
                'description' => 'Ultimate premium package',
                'sharing_price' => 599000,
                'private_price' => 699000,
                'sharing_description' => 'Luxury sharing experience with friends',
                'private_description' => 'VIP private package with all premium features',
                'image' => 'products/package-c.jpg',
                'is_active' => true,
                'order' => 3,
                'sharing_discount' => 20,
                'private_discount' => 25,
                'is_promo' => true,
                'promo_ends_at' => now()->addDays(3),
            ],
            [
                'name' => 'Premium Everyday Package A',
                'description' => 'Complete package for your daily needs',
                'sharing_price' => 299000,
                'private_price' => 399000,
                'sharing_description' => 'Perfect for sharing with friends - includes all basic items',
                'private_description' => 'Exclusive private package with premium items',
                'image' => 'products/package-a.jpg',
                'is_active' => true,
                'order' => 1,
                'sharing_discount' => 10,
                'private_discount' => 15,
                'is_promo' => true,
                'promo_ends_at' => now()->addDays(7),
            ],
            [
                'name' => 'Premium Everyday Package B',
                'description' => 'Enhanced package with additional items',
                'sharing_price' => 399000,
                'private_price' => 499000,
                'sharing_description' => 'Sharing package with premium features',
                'private_description' => 'Private package with exclusive benefits',
                'image' => 'products/package-b.jpg',
                'is_active' => true,
                'order' => 2,
                'sharing_discount' => 0,
                'private_discount' => 0,
                'is_promo' => false,
                'promo_ends_at' => null,
            ],
            [
                'name' => 'Premium Everyday Package C',
                'description' => 'Ultimate premium package',
                'sharing_price' => 599000,
                'private_price' => 699000,
                'sharing_description' => 'Luxury sharing experience with friends',
                'private_description' => 'VIP private package with all premium features',
                'image' => 'products/package-c.jpg',
                'is_active' => true,
                'order' => 3,
                'sharing_discount' => 20,
                'private_discount' => 25,
                'is_promo' => true,
                'promo_ends_at' => now()->addDays(3),
            ],
            [
                'name' => 'Premium Everyday Package A',
                'description' => 'Complete package for your daily needs',
                'sharing_price' => 299000,
                'private_price' => 399000,
                'sharing_description' => 'Perfect for sharing with friends - includes all basic items',
                'private_description' => 'Exclusive private package with premium items',
                'image' => 'products/package-a.jpg',
                'is_active' => true,
                'order' => 1,
                'sharing_discount' => 10,
                'private_discount' => 15,
                'is_promo' => true,
                'promo_ends_at' => now()->addDays(7),
            ],
            [
                'name' => 'Premium Everyday Package B',
                'description' => 'Enhanced package with additional items',
                'sharing_price' => 399000,
                'private_price' => 499000,
                'sharing_description' => 'Sharing package with premium features',
                'private_description' => 'Private package with exclusive benefits',
                'image' => 'products/package-b.jpg',
                'is_active' => true,
                'order' => 2,
                'sharing_discount' => 0,
                'private_discount' => 0,
                'is_promo' => false,
                'promo_ends_at' => null,
            ],
            [
                'name' => 'Premium Everyday Package C',
                'description' => 'Ultimate premium package',
                'sharing_price' => 599000,
                'private_price' => 699000,
                'sharing_description' => 'Luxury sharing experience with friends',
                'private_description' => 'VIP private package with all premium features',
                'image' => 'products/package-c.jpg',
                'is_active' => true,
                'order' => 3,
                'sharing_discount' => 20,
                'private_discount' => 25,
                'is_promo' => true,
                'promo_ends_at' => now()->addDays(3),
            ],
            [
                'name' => 'Premium Everyday Package A',
                'description' => 'Complete package for your daily needs',
                'sharing_price' => 299000,
                'private_price' => 399000,
                'sharing_description' => 'Perfect for sharing with friends - includes all basic items',
                'private_description' => 'Exclusive private package with premium items',
                'image' => 'products/package-a.jpg',
                'is_active' => true,
                'order' => 1,
                'sharing_discount' => 10,
                'private_discount' => 15,
                'is_promo' => true,
                'promo_ends_at' => now()->addDays(7),
            ],
            [
                'name' => 'Premium Everyday Package B',
                'description' => 'Enhanced package with additional items',
                'sharing_price' => 399000,
                'private_price' => 499000,
                'sharing_description' => 'Sharing package with premium features',
                'private_description' => 'Private package with exclusive benefits',
                'image' => 'products/package-b.jpg',
                'is_active' => true,
                'order' => 2,
                'sharing_discount' => 0,
                'private_discount' => 0,
                'is_promo' => false,
                'promo_ends_at' => null,
            ],
            [
                'name' => 'Premium Everyday Package C',
                'description' => 'Ultimate premium package',
                'sharing_price' => 599000,
                'private_price' => 699000,
                'sharing_description' => 'Luxury sharing experience with friends',
                'private_description' => 'VIP private package with all premium features',
                'image' => 'products/package-c.jpg',
                'is_active' => true,
                'order' => 3,
                'sharing_discount' => 20,
                'private_discount' => 25,
                'is_promo' => true,
                'promo_ends_at' => now()->addDays(3),
            ],
        ];

        foreach ($products as $product) {
            // Copy default image if not exists
            $sourcePath = public_path('images/placeholder.webp');
            $destinationPath = storage_path('app/public/' . $product['image']);
            
            if (!File::exists($destinationPath)) {
                File::copy($sourcePath, $destinationPath);
            }
            
            Product::create($product);
        }
    }
}
