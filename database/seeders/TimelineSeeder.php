<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Timeline;

class TimelineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timelines = [
            [
                'title' => 'Company Founded',
                'description' => 'Premium Everyday was founded with a mission to provide high-quality products for everyday use.',
                'date' => '2015-01-15',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'First Product Launch',
                'description' => 'We launched our first product line, focusing on premium electronics and accessories.',
                'date' => '2015-06-20',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'title' => 'Expansion to Clothing',
                'description' => 'Expanded our product offerings to include premium clothing and apparel.',
                'date' => '2016-03-10',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'title' => 'Online Store Launch',
                'description' => 'Launched our e-commerce platform to reach customers worldwide.',
                'date' => '2017-05-15',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'title' => 'First International Expansion',
                'description' => 'Expanded operations to Europe and Asia, opening offices in London and Tokyo.',
                'date' => '2018-09-22',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'title' => 'Premium Membership Program',
                'description' => 'Introduced our premium membership program with exclusive benefits for loyal customers.',
                'date' => '2019-11-01',
                'is_active' => true,
                'order' => 6,
            ],
            [
                'title' => 'Sustainable Initiative Launch',
                'description' => 'Committed to sustainability with eco-friendly packaging and carbon-neutral shipping.',
                'date' => '2020-04-22',
                'is_active' => true,
                'order' => 7,
            ],
            [
                'title' => 'Mobile App Launch',
                'description' => 'Released our mobile app for iOS and Android, enhancing the shopping experience.',
                'date' => '2021-07-15',
                'is_active' => true,
                'order' => 8,
            ],
            [
                'title' => 'One Million Customers',
                'description' => 'Celebrated serving our one millionth customer worldwide.',
                'date' => '2022-12-01',
                'is_active' => true,
                'order' => 9,
            ],
            [
                'title' => 'New Website Launch',
                'description' => 'Launched our redesigned website with enhanced features and user experience.',
                'date' => '2023-10-10',
                'is_active' => true,
                'order' => 10,
            ],
        ];

        foreach ($timelines as $timelineData) {
            Timeline::create($timelineData);
        }
    }
} 