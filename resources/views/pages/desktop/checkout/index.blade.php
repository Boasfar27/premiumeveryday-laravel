@extends('pages.desktop.layouts.app')

@section('title', 'Checkout - Premium Everyday')

@section('content')
    <div class="bg-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Order Details -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Details</h2>

                            <div class="border-b border-gray-200 pb-6 mb-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Order #{{ $orderNumber }}</h3>

                                <div class="space-y-4">
                                    @foreach ($products as $item)
                                        <div class="flex items-start">
                                            <img src="{{ $item['product']->thumbnail_url }}"
                                                alt="{{ $item['product']->name }}"
                                                class="w-16 h-16 object-cover rounded-md">
                                            <div class="ml-4 flex-1">
                                                <h4 class="text-base font-medium text-gray-900">{{ $item['product']->name }}
                                                </h4>
                                                <p class="text-sm text-gray-500">
                                                    {{ ucfirst($item['subscription_type']) }} |
                                                    {{ $item['duration'] }} {{ Str::plural('Month', $item['duration']) }} |
                                                    {{ ucfirst($item['account_type']) }} Account
                                                </p>
                                                <div class="flex justify-between mt-1">
                                                    <span class="text-sm text-gray-600">Qty: {{ $item['quantity'] }}</span>
                                                    <span class="text-base font-medium text-gray-900">Rp
                                                        {{ number_format($item['total'], 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Customer Information -->
                            <div class="mb-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Customer Information</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Name</p>
                                        <p class="text-base font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Email</p>
                                        <p class="text-base font-medium text-gray-900">{{ auth()->user()->email }}</p>
                                    </div>
                                    @if (auth()->user()->phone)
                                        <div>
                                            <p class="text-sm text-gray-600">Phone</p>
                                            <p class="text-base font-medium text-gray-900">{{ auth()->user()->phone }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Methods -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden mt-6">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Payment Methods</h2>

                            <p class="text-gray-600 mb-4">
                                By clicking "Place Order", you will be redirected to Midtrans secure payment gateway. There,
                                you
                                can select your preferred payment method.
                            </p>

                            <p class="text-sm text-gray-500 mb-6">
                                Available payment options: GoPay, QRIS, various bank transfers, and e-wallets.
                            </p>

                            <!-- Terms and Conditions -->
                            <form action="{{ route('process.payment') }}" method="POST" class="space-y-6">
                                @csrf
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="terms" name="terms" type="checkbox"
                                            class="h-4 w-4 rounded border-gray-300 text-pink-600 focus:ring-pink-500">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="terms" class="font-medium text-gray-700">I agree to the</label>
                                        <a href="{{ route('legal.terms') }}" class="text-pink-600 hover:text-pink-700"
                                            target="_blank">Terms and Conditions</a>
                                        <p class="text-gray-500">By placing your order, you agree to our terms and
                                            conditions.</p>
                                    </div>
                                </div>

                                @error('terms')
                                    <div class="text-red-500 text-sm">You must agree to the terms and conditions to proceed.
                                    </div>
                                @enderror

                                <button type="submit"
                                    class="w-full bg-pink-600 hover:bg-pink-700 text-white py-3 px-4 rounded-md shadow-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                    Place Order
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden sticky top-24">
                        <div class="p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>

                            <!-- Price Summary -->
                            <div class="space-y-3 border-b border-gray-200 pb-6 mb-6">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>

                                @if ($discount > 0)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Discount</span>
                                        <span class="font-medium text-green-600">- Rp
                                            {{ number_format($discount, 0, ',', '.') }}</span>
                                    </div>
                                @endif

                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tax ({{ App\Models\Setting::get('tax_rate', 5) }}%)</span>
                                    <span class="font-medium">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <!-- Total -->
                            <div class="flex justify-between">
                                <span class="text-lg font-medium text-gray-900">Total</span>
                                <span class="text-xl font-bold text-pink-600">Rp
                                    {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const paymentForm = document.getElementById('payment-form');
                // Form validation logic if needed can be added here
            });
        </script>
    @endpush
@endsection
