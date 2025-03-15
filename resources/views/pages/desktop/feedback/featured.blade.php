<!-- Feedback Section -->
<section class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl mb-4">What Our Customers Say</h2>
            <p class="text-lg text-gray-600 mb-12">Read testimonials from our satisfied customers</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($feedbacks as $feedback)
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center mb-4">
                        @if ($feedback->avatar)
                            <img src="{{ asset($feedback->avatar) }}" alt="{{ $feedback->name }}"
                                class="w-12 h-12 rounded-full object-cover">
                        @else
                            <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center">
                                <span
                                    class="text-xl font-medium text-primary-600">{{ substr($feedback->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ $feedback->name }}</h3>
                            @if ($feedback->product)
                                <p class="text-sm text-gray-500">on {{ $feedback->product->name }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Rating Stars -->
                    <div class="flex items-center mb-4">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $feedback->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>

                    <p class="text-gray-600 mb-4">{{ $feedback->content }}</p>

                    <div class="text-sm text-gray-500">
                        {{ $feedback->created_at->format('d M Y') }}
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No feedback yet</h3>
                    <p class="text-gray-500">Be the first to share your experience with us.</p>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('feedback.index') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary-dark transition-colors">
                Share Your Experience
                <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</section>
