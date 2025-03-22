<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            [
                'type' => 'phone',
                'value' => '+628123456789',
                'icon' => 'phone',
                'link' => 'tel:+628123456789',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'type' => 'email',
                'value' => 'info@premiumeveryday.com',
                'icon' => 'envelope',
                'link' => 'mailto:info@premiumeveryday.com',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'type' => 'whatsapp',
                'value' => '+628123456789',
                'icon' => 'whatsapp',
                'link' => 'https://wa.me/628123456789',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'type' => 'address',
                'value' => 'Jl. Puri Indah No. 123, Jakarta Barat',
                'icon' => 'map-marker',
                'link' => 'https://maps.google.com/?q=Jl.+Puri+Indah+No.+123,+Jakarta+Barat',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'type' => 'instagram',
                'value' => '@premium_everyday',
                'icon' => 'instagram',
                'link' => 'https://instagram.com/premium_everyday',
                'is_active' => true,
                'order' => 5,
            ],
        ];

        foreach ($contacts as $contactData) {
            Contact::updateOrCreate(
                ['type' => $contactData['type']],
                $contactData
            );
        }
    }
} 