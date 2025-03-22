@extends('pages.desktop.layouts.app')

@section('title', $existingReview ? 'Edit Review' : 'Leave Review')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-4xl mx-auto">
            <nav class="mb-6" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li>
                        <a href="{{ route('home') }}" class="hover:text-gray-700">Home</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <a href="{{ route('user.payments.history') }}" class="ml-2 hover:text-gray-700">Pembayaran</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <a href="{{ route('user.payments.detail', $order) }}" class="ml-2 hover:text-gray-700">Order
                            #{{ $order->order_number }}</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="ml-2 font-medium text-gray-900">
                            {{ $existingReview ? 'Edit Review' : 'Leave Review' }}
                        </span>
                    </li>
                </ol>
            </nav>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                    <h1 class="text-lg leading-6 font-medium text-gray-900">
                        {{ $existingReview ? 'Edit Review' : 'Leave Review' }}
                    </h1>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Please share your honest opinion about this order
                    </p>
                </div>

                <div class="px-4 py-5 sm:p-6">
                    <!-- Review Form -->
                    <form action="{{ route('user.payments.review.store', $order) }}" method="POST">
                        @csrf

                        <!-- Rating -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                            <div class="flex items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="mr-2">
                                        <input type="radio" id="rating-{{ $i }}" name="rating"
                                            value="{{ $i }}"
                                            {{ old('rating', $existingReview->rating ?? 5) == $i ? 'checked' : '' }}>
                                        <label for="rating-{{ $i }}" class="cursor-pointer">
                                            <svg class="h-8 w-8 {{ $i <= old('rating', $existingReview->rating ?? 5) ? 'text-yellow-400' : 'text-gray-300' }}"
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
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="mb-6">
                            <label for="content" class="block text-sm font-medium text-gray-700">Your Review</label>
                            <textarea id="content" name="content" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                                placeholder="Share your experience with this product...">{{ old('content', $existingReview->content ?? '') }}</textarea>
                            @error('content')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('user.payments.detail', $order) }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Cancel
                            </a>
                            <div class="mt-6">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                    Submit Review
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
