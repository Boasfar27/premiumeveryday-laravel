<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            [
                'name' => 'Customer Support',
                'email' => 'support@premiumeveryday.com',
                'phone' => '+1-800-123-4567',
                'address' => '123 Main Street, Suite 100, New York, NY 10001',
                'hours' => 'Monday-Friday: 9am-5pm EST',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Sales Department',
                'email' => 'sales@premiumeveryday.com',
                'phone' => '+1-800-765-4321',
                'address' => '123 Main Street, Suite 200, New York, NY 10001',
                'hours' => 'Monday-Friday: 9am-6pm EST',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Technical Support',
                'email' => 'tech@premiumeveryday.com',
                'phone' => '+1-800-987-6543',
                'address' => '123 Main Street, Suite 300, New York, NY 10001',
                'hours' => 'Monday-Sunday: 24/7 Support',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Returns & Exchanges',
                'email' => 'returns@premiumeveryday.com',
                'phone' => '+1-800-456-7890',
                'address' => '456 Warehouse Blvd, Jersey City, NJ 07302',
                'hours' => 'Monday-Friday: 10am-4pm EST',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Corporate Headquarters',
                'email' => 'info@premiumeveryday.com',
                'phone' => '+1-212-555-1234',
                'address' => '789 Corporate Plaza, 15th Floor, New York, NY 10022',
                'hours' => 'By appointment only',
                'is_active' => true,
                'order' => 5,
            ],
        ];

        foreach ($contacts as $contactData) {
            Contact::create($contactData);
        }
    }
} 