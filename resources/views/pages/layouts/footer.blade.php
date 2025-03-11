<!-- Footer -->
<footer class="bg-primary text-white">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Company Info -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Premium Everyday</h3>
                <p class="text-gray-300">Solusi terbaik untuk kebutuhan premium Anda setiap hari.</p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Tautan</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('products') }}" class="text-gray-300 hover:text-white transition-colors">
                            Produk
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('timeline') }}" class="text-gray-300 hover:text-white transition-colors">
                            Timeline
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('faq') }}" class="text-gray-300 hover:text-white transition-colors">
                            FAQ
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="text-gray-300 hover:text-white transition-colors">
                            Kontak
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Kontak</h3>
                <ul class="space-y-2">
                    <li class="flex items-center text-gray-300">
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        info@premiumeveryday.com
                    </li>
                    <li class="flex items-center text-gray-300">
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                        +62 812-3456-7890
                    </li>
                    <li class="flex items-center text-gray-300">
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        Jakarta, Indonesia
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-8 pt-8 border-t border-gray-700">
            <p class="text-center text-gray-300 text-sm">
                &copy; {{ date('Y') }} Premium Everyday. All rights reserved.
            </p>
        </div>
    </div>
</footer> 