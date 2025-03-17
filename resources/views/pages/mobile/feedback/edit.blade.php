@extends('pages.mobile.layouts.app')

@section('content')
    <div class="bg-gray-100 min-h-screen pb-12">
        <div class="bg-white shadow">
            <div class="px-4 py-5">
                <div class="flex items-center">
                    <a href="{{ route('user.orders.show', $order->id) }}" class="mr-2">
                        <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </a>
                    <h1 class="text-xl font-semibold text-gray-900">Edit Feedback</h1>
                </div>
                <p class="mt-1 text-sm text-gray-600">Order #{{ $order->order_number }}</p>
            </div>
        </div>

        <div class="px-4 py-5">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow mb-5">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Order Summary</h2>
                </div>
                <div class="p-4">
                    <dl class="grid grid-cols-2 gap-x-4 gap-y-2">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="text-sm text-gray-900">
                            <span
                                class="px-2 py-1 text-xs font-semibold rounded-full 
                            bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-800">
                                {{ $order->getFormattedStatusAttribute() }}
                            </span>
                        </dd>
                        <dt class="text-sm font-medium text-gray-500">Total</dt>
                        <dd class="text-sm font-semibold text-gray-900">{{ $order->getFormattedTotalAttribute() }}</dd>
                    </dl>
                </div>

                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Products</h3>
                    <ul class="text-sm text-gray-600">
                        @foreach ($order->items as $item)
                            <li class="py-1">{{ $item->name }} (x{{ $item->quantity }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Feedback Form -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Edit Your Feedback</h2>
                </div>
                <div class="p-4">
                    <form
                        action="{{ route('user.orders.feedback.update', ['order' => $order->id, 'feedback' => $feedback->id]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label for="rating" class="block text-sm font-medium text-gray-700 mb-3">Rating</label>
                            <div class="flex items-center space-x-3">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="flex items-center">
                                        <input type="radio" id="rating-{{ $i }}" name="rating"
                                            value="{{ $i }}"
                                            class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                            {{ old('rating', $feedback->rating) == $i ? 'checked' : '' }} required>
                                        <label for="rating-{{ $i }}" class="ml-1">
                                            <svg class="h-5 w-5 {{ $i <= old('rating', $feedback->rating) ? 'text-yellow-400' : 'text-gray-300' }}"
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

                        <div class="mb-6">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Your Feedback</label>
                            <textarea id="content" name="content" rows="4"
                                class="shadow-sm block w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"
                                placeholder="Share your experience with this order..." required>{{ old('content', $feedback->content) }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-between items-center">
                            <div>
                                <form
                                    action="{{ route('user.orders.feedback.destroy', ['order' => $order->id, 'feedback' => $feedback->id]) }}"
                                    method="POST" class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this feedback?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg class="-ml-0.5 mr-1 h-4 w-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ route('user.orders.show', $order->id) }}"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
