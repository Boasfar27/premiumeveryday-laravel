<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'How do I place an order?',
                'answer' => 'You can place an order by browsing our products, adding items to your cart, and proceeding to checkout. Follow the steps to enter your shipping and payment information to complete your purchase.',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept credit/debit cards (Visa, Mastercard, American Express), PayPal, bank transfers, and cash on delivery for eligible locations.',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'question' => 'How long does shipping take?',
                'answer' => 'Shipping times vary depending on your location. Domestic orders typically arrive within 3-5 business days, while international orders may take 7-14 business days. You can track your order through your account dashboard.',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'question' => 'What is your return policy?',
                'answer' => 'We offer a 30-day return policy for most items. Products must be in their original condition with all packaging and tags. Please contact our customer service team to initiate a return.',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'question' => 'Do you offer international shipping?',
                'answer' => 'Yes, we ship to most countries worldwide. International shipping rates and delivery times vary by location. You can see the shipping options available to your country during checkout.',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'question' => 'How can I track my order?',
                'answer' => 'Once your order ships, you will receive a tracking number via email. You can also view your order status and tracking information in your account dashboard under "Orders".',
                'is_active' => true,
                'order' => 6,
            ],
            [
                'question' => 'Are there any discounts or promotions available?',
                'answer' => 'We regularly offer promotions and discounts. Sign up for our newsletter to receive updates on our latest deals. You can also check our website for current promotions or use coupon codes during checkout.',
                'is_active' => true,
                'order' => 7,
            ],
            [
                'question' => 'How do I contact customer support?',
                'answer' => 'You can reach our customer support team through the Contact page on our website, by email at support@premiumeveryday.com, or by phone at +1-800-123-4567 during business hours.',
                'is_active' => true,
                'order' => 8,
            ],
        ];

        foreach ($faqs as $faqData) {
            Faq::create($faqData);
        }
    }
} 