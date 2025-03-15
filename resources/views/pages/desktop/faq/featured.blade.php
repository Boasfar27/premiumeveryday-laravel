<!-- FAQ Section -->
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl mb-4">Frequently Asked Questions</h2>
            <p class="text-lg text-gray-600 mb-12">Find answers to common questions about our products and services</p>
        </div>

        <div class="max-w-3xl mx-auto divide-y divide-gray-200">
            @forelse ($faqs as $faq)
                <div class="py-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                        {{ $faq->question }}
                    </h3>
                    <p class="text-gray-600">
                        {{ $faq->answer }}
                    </p>
                </div>
            @empty
                <div class="text-center py-12">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No FAQs available</h3>
                    <p class="text-gray-500">Check back later for frequently asked questions.</p>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-12">
            <p class="text-gray-600">Still have questions?</p>
            <a href="{{ route('contact') }}"
                class="inline-flex items-center mt-2 px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary-dark transition-colors">
                Contact Us
                <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</section>
