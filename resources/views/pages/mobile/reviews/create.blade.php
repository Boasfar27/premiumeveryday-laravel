@extends('pages.mobile.layouts.app')

@section('title', $existingReview ? 'Edit Review' : 'Submit Review')

@section('content')
    <div class="min-h-screen bg-gray-100">
        <!-- Header -->
        <div class="bg-white shadow">
            <div class="px-4 py-4 flex items-center justify-between">
                <a href="{{ route('user.payments.detail', $order) }}" class="text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-xl font-semibold text-gray-900">{{ $existingReview ? 'Edit Review' : 'Leave Review' }}</h1>
                <div class="w-6"></div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="px-4 py-6">
            <div class="bg-white rounded-lg shadow-sm mb-6">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Order Details</h2>
                </div>
                <div class="p-4 border-b border-gray-200">
                    <p class="text-sm text-gray-600">Order #{{ $order->order_number }}</p>
                    <p class="text-sm text-gray-600 mt-1">Placed on {{ $order->created_at->format('d M Y') }}</p>
                    <div class="mt-2">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $order->status == 'completed'
                            ? 'bg-green-100 text-green-800'
                            : ($order->status == 'cancelled'
                                ? 'bg-red-100 text-red-800'
                                : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Feedback Form -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Your Review</h2>
                </div>

                <div class="p-4">
                    <form action="{{ route('user.payments.review.store', $order->id) }}" method="POST">
                        @csrf

                        <!-- Rating -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                            <div class="flex items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="mr-1">
                                        <input type="radio" id="rating-{{ $i }}" name="rating"
                                            value="{{ $i }}"
                                            {{ old('rating', $existingReview->rating ?? 5) == $i ? 'checked' : '' }}
                                            required>
                                        <label for="rating-{{ $i }}" class="cursor-pointer">
                                            <svg class="h-6 w-6 {{ $i <= old('rating', $existingReview->rating ?? 5) ? 'text-yellow-400' : 'text-gray-300' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                </path>
                                            </svg>
                                        </label>
                                    </div>
                                @endfor
                            </div>
                            @error('rating')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Your Review</label>
                            <textarea id="content" name="content" rows="4"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                                placeholder="Share your experience with this order..." required>{{ old('content', $existingReview->content ?? '') }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6">
                            <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                {{ $existingReview ? 'Update Review' : 'Submit Review' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
