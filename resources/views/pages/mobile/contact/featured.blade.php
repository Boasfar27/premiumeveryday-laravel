<!-- Mobile Featured Contact -->
<section class="bg-white py-8">
    <div class="px-4">
        <!-- Section Header -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Contact Us</h2>
            <p class="text-gray-600">Get in touch with our team for any inquiries</p>
        </div>

        <!-- Contact Information -->
        @if ($contacts->count() > 0)
            <div class="space-y-6">
                @foreach ($contacts as $contact)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
                        <!-- Contact Type -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                @switch($contact->type)
                                    @case('phone')
                                        <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    @break

                                    @case('email')
                                        <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    @break

                                    @case('address')
                                        <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    @break

                                    @default
                                        <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                @endswitch
                            </div>

                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-900">
                                    {{ $contact->title }}
                                </h3>
                                <div class="mt-1 text-sm text-gray-600">
                                    @switch($contact->type)
                                        @case('phone')
                                            <a href="tel:{{ $contact->value }}" class="hover:text-primary">
                                                {{ $contact->value }}
                                            </a>
                                        @break

                                        @case('email')
                                            <a href="mailto:{{ $contact->value }}" class="hover:text-primary">
                                                {{ $contact->value }}
                                            </a>
                                        @break

                                        @default
                                            {!! nl2br(e($contact->value)) !!}
                                    @endswitch
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Contact Form Button -->
            <div class="mt-8 text-center">
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Send us a Message
                </a>
            </div>
        @else
            <!-- No Contact Info State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No contact information available</h3>
                <p class="mt-1 text-sm text-gray-500">Please check back later!</p>
            </div>
        @endif
    </div>
</section>
