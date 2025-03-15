<!-- Mobile Featured FAQ -->
<section class="bg-white py-8">
    <div class="px-4">
        <!-- Section Header -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Frequently Asked Questions</h2>
            <p class="text-gray-600">Find answers to common questions about our products and services</p>
        </div>

        <!-- FAQ List -->
        @if ($faqs->count() > 0)
            <div class="space-y-4">
                @foreach ($faqs as $faq)
                    <div x-data="{ open: false }" class="bg-white rounded-lg shadow-sm border border-gray-100">
                        <!-- Question -->
                        <button @click="open = !open"
                            class="w-full px-4 py-3 text-left focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-medium text-gray-900">
                                    {{ $faq->question }}
                                </h3>
                                <svg class="h-5 w-5 text-gray-500 transform transition-transform duration-200"
                                    :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>

                        <!-- Answer -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-1" class="px-4 pb-3">
                            <p class="text-sm text-gray-600">
                                {{ $faq->answer }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- View All FAQs Button -->
            <div class="mt-8 text-center">
                <a href="{{ route('faq') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    View All FAQs
                </a>
            </div>
        @else
            <!-- No FAQs State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No FAQs available</h3>
                <p class="mt-1 text-sm text-gray-500">Check back soon for helpful information!</p>
            </div>
        @endif
    </div>
</section>
