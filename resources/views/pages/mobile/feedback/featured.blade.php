<!-- Mobile Featured Feedback -->
<section class="bg-white py-8">
    <div class="px-4">
        <!-- Section Header -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">What Our Customers Say</h2>
            <p class="text-gray-600">Read testimonials from our satisfied customers</p>
        </div>

        <!-- Feedback Grid -->
        @if ($feedbacks->count() > 0)
            <div class="space-y-6">
                @foreach ($feedbacks as $feedback)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
                        <div class="flex items-start">
                            <!-- User Avatar/Initial -->
                            <div class="flex-shrink-0">
                                @if ($feedback->user && $feedback->user->avatar)
                                    <img class="h-10 w-10 rounded-full object-cover"
                                        src="{{ asset($feedback->user->avatar) }}" alt="{{ $feedback->name }}">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                        <span class="text-primary-600 font-medium text-sm">
                                            {{ substr($feedback->name, 0, 1) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Feedback Content -->
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $feedback->name }}</h4>
                                        @if ($feedback->feedbackable)
                                            <p class="text-xs text-gray-500">{{ $feedback->feedbackable->name }}</p>
                                        @endif
                                    </div>
                                    <time class="text-xs text-gray-500"
                                        datetime="{{ $feedback->created_at->toISOString() }}">
                                        {{ $feedback->created_at->diffForHumans() }}
                                    </time>
                                </div>

                                <!-- Rating -->
                                <div class="flex items-center mt-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="h-4 w-4 {{ $i <= $feedback->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>

                                <!-- Content -->
                                <p class="mt-2 text-sm text-gray-600">{{ $feedback->content }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Share Experience Button -->
            <div class="mt-8 text-center">
                <a href="{{ route('feedback.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Share Your Experience
                </a>
            </div>
        @else
            <!-- No Feedback State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No feedback yet</h3>
                <p class="mt-1 text-sm text-gray-500">Be the first to share your experience!</p>
                <div class="mt-6">
                    <a href="{{ route('feedback.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Share Your Experience
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>
