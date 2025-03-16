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
                'type' => 'email',
                'value' => 'support@premiumeveryday.com',
                'icon' => 'far fa-envelope',
                'link' => 'mailto:support@premiumeveryday.com',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'type' => 'phone',
                'value' => '+62 812-3456-7890',
                'icon' => 'fas fa-phone-alt',
                'link' => 'tel:+6281234567890',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'type' => 'whatsapp',
                'value' => '+62 812-3456-7890',
                'icon' => 'fab fa-whatsapp',
                'link' => 'https://wa.me/6281234567890',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'type' => 'instagram',
                'value' => '@premiumeveryday',
                'icon' => 'fab fa-instagram',
                'link' => 'https://instagram.com/premiumeveryday',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'type' => 'telegram',
                'value' => '@premiumeveryday',
                'icon' => 'fab fa-telegram-plane',
                'link' => 'https://t.me/premiumeveryday',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'type' => 'address',
                'value' => 'Jl. Gatot Subroto No. 123, Jakarta Selatan, DKI Jakarta 12930',
                'icon' => 'fas fa-map-marker-alt',
                'link' => 'https://goo.gl/maps/123',
                'is_active' => true,
                'order' => 6,
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::updateOrCreate(
                ['type' => $contact['type']],
                $contact
            );
        }
    }
} 