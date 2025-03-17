@extends('pages.desktop.layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">
                    {{ $existingFeedback ? 'Edit Feedback' : 'Leave Feedback' }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">Order #{{ $order->order_number }}</p>
            </div>

            <div class="p-6">
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

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Order Details</h3>
                    <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <p class="font-medium text-gray-900">{{ $order->getFormattedStatusAttribute() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total</p>
                            <p class="font-medium text-gray-900">{{ $order->getFormattedTotalAttribute() }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-600">Products</p>
                            <ul class="mt-1 list-disc list-inside">
                                @foreach ($order->items as $item)
                                    <li class="font-medium text-gray-900">{{ $item->name }} x {{ $item->quantity }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <form action="{{ route('user.orders.feedback.store', $order) }}" method="POST">
                    @csrf

                    <div class="space-y-6">
                        <div>
                            <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                            <div class="mt-2 flex items-center space-x-2">
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center mr-4 cursor-pointer">
                                            <input type="radio" name="rating" value="{{ $i }}"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                                {{ old('rating', $existingFeedback->rating ?? 5) == $i ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm font-medium text-gray-700">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                            @error('rating')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700">Your Feedback</label>
                            <div class="mt-1">
                                <textarea id="content" name="content" rows="4"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                    placeholder="Share your experience with this product...">{{ old('content', $existingFeedback->content ?? '') }}</textarea>
                            </div>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('user.orders.show', $order) }}"
                                class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ $existingFeedback ? 'Update Feedback' : 'Submit Feedback' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
