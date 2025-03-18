@extends('pages.mobile.layouts.app')

@section('title', 'Checkout - Premium Everyday')

@section('content')
    <div class="bg-white min-h-screen pb-24">
        <!-- Back Button and Title -->
        <div class="relative bg-white shadow">
            <div class="flex items-center h-16 px-4">
                <a href="{{ route('cart.index') }}" class="mr-4">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18">
                        </path>
                    </svg>
                </a>
                <h1 class="text-xl font-bold text-gray-900">Checkout</h1>
            </div>
        </div>

        <div class="px-4 py-6">
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

            <!-- Order Details -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <div class="p-4">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Order Details</h2>

                    <div class="border-b border-gray-200 pb-4 mb-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Order #{{ $orderNumber }}</h3>

                        <div class="space-y-4">
                            @foreach ($products as $item)
                                <div class="flex items-start">
                                    <img src="{{ $item['product']->thumbnail_url }}" alt="{{ $item['product']->name }}"
                                        class="w-12 h-12 object-cover rounded-md">
                                    <div class="ml-3 flex-1">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $item['product']->name }}</h4>
                                        <p class="text-xs text-gray-500">
                                            {{ ucfirst($item['subscription_type']) }} |
                                            {{ $item['duration'] }} {{ Str::plural('Month', $item['duration']) }} |
                                            {{ ucfirst($item['account_type']) }} Account
                                        </p>
                                        <div class="flex justify-between mt-1">
                                            <span class="text-xs text-gray-600">Qty: {{ $item['quantity'] }}</span>
                                            <span class="text-sm font-medium text-gray-900">Rp
                                                {{ number_format($item['total'], 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Customer Information</h3>

                        <div class="space-y-2">
                            <div>
                                <p class="text-xs text-gray-600">Name</p>
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600">Email</p>
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->email }}</p>
                            </div>
                            @if (auth()->user()->phone)
                                <div>
                                    <p class="text-xs text-gray-600">Phone</p>
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->phone }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <div class="p-4">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Payment Method</h2>

                    <form action="{{ route('process.payment') }}" method="POST" id="payment-form">
                        @csrf
                        <div class="space-y-4">
                            <!-- Payment Options -->
                            <div>
                                <label class="block text-base font-medium text-gray-900 mb-3">
                                    Select Payment Methods
                                </label>

                                <div class="space-y-3">
                                    <!-- Mandiri VA -->
                                    <label
                                        class="relative flex items-center p-3 border border-gray-300 rounded-md cursor-pointer hover:border-primary hover:bg-gray-50 transition">
                                        <input type="checkbox" name="payment_method[]" value="mandiri_va"
                                            class="h-5 w-5 text-primary focus:ring-primary rounded">
                                        <div class="ml-3 flex items-center justify-between flex-1">
                                            <span class="text-sm font-medium text-gray-900">Mandiri VA</span>
                                            <img src="{{ asset('images/payment/mandiri.png') }}" alt="Mandiri VA"
                                                class="h-7">
                                        </div>
                                    </label>

                                    <!-- BNI VA -->
                                    <label
                                        class="relative flex items-center p-3 border border-gray-300 rounded-md cursor-pointer hover:border-primary hover:bg-gray-50 transition">
                                        <input type="checkbox" name="payment_method[]" value="bni_va"
                                            class="h-5 w-5 text-primary focus:ring-primary rounded">
                                        <div class="ml-3 flex items-center justify-between flex-1">
                                            <span class="text-sm font-medium text-gray-900">BNI VA</span>
                                            <img src="{{ asset('images/payment/bni.png') }}" alt="BNI VA" class="h-7">
                                        </div>
                                    </label>

                                    <!-- BRI VA -->
                                    <label
                                        class="relative flex items-center p-3 border border-gray-300 rounded-md cursor-pointer hover:border-primary hover:bg-gray-50 transition">
                                        <input type="checkbox" name="payment_method[]" value="bri_va"
                                            class="h-5 w-5 text-primary focus:ring-primary rounded">
                                        <div class="ml-3 flex items-center justify-between flex-1">
                                            <span class="text-sm font-medium text-gray-900">BRI VA</span>
                                            <img src="{{ asset('images/payment/bri.png') }}" alt="BRI VA" class="h-7">
                                        </div>
                                    </label>

                                    <!-- CIMB VA -->
                                    <label
                                        class="relative flex items-center p-3 border border-gray-300 rounded-md cursor-pointer hover:border-primary hover:bg-gray-50 transition">
                                        <input type="checkbox" name="payment_method[]" value="cimb_va"
                                            class="h-5 w-5 text-primary focus:ring-primary rounded">
                                        <div class="ml-3 flex items-center justify-between flex-1">
                                            <span class="text-sm font-medium text-gray-900">CIMB VA</span>
                                            <img src="{{ asset('images/payment/cimb.png') }}" alt="CIMB VA"
                                                class="h-7">
                                        </div>
                                    </label>

                                    <!-- GO-PAY -->
                                    <label
                                        class="relative flex items-center p-3 border border-gray-300 rounded-md cursor-pointer hover:border-primary hover:bg-gray-50 transition">
                                        <input type="checkbox" name="payment_method[]" value="gopay"
                                            class="h-5 w-5 text-primary focus:ring-primary rounded">
                                        <div class="ml-3 flex items-center justify-between flex-1">
                                            <span class="text-sm font-medium text-gray-900">GO-PAY</span>
                                            <img src="{{ asset('images/payment/gopay.png') }}" alt="GO-PAY"
                                                class="h-7">
                                        </div>
                                    </label>

                                    <!-- Permata VA -->
                                    <label
                                        class="relative flex items-center p-3 border border-gray-300 rounded-md cursor-pointer hover:border-primary hover:bg-gray-50 transition">
                                        <input type="checkbox" name="payment_method[]" value="permata_va"
                                            class="h-5 w-5 text-primary focus:ring-primary rounded">
                                        <div class="ml-3 flex items-center justify-between flex-1">
                                            <span class="text-sm font-medium text-gray-900">Permata VA</span>
                                            <img src="{{ asset('images/payment/permata.png') }}" alt="Permata VA"
                                                class="h-7">
                                        </div>
                                    </label>

                                    <!-- Other VA -->
                                    <label
                                        class="relative flex items-center p-3 border border-gray-300 rounded-md cursor-pointer hover:border-primary hover:bg-gray-50 transition">
                                        <input type="checkbox" name="payment_method[]" value="other_va"
                                            class="h-5 w-5 text-primary focus:ring-primary rounded">
                                        <div class="ml-3 flex items-center justify-between flex-1">
                                            <span class="text-sm font-medium text-gray-900">Other VA</span>
                                            <img src="{{ asset('images/payment/other_bank.png') }}" alt="Other VA"
                                                class="h-7">
                                        </div>
                                    </label>

                                    <!-- Other QRIS -->
                                    <label
                                        class="relative flex items-center p-3 border border-gray-300 rounded-md cursor-pointer hover:border-primary hover:bg-gray-50 transition">
                                        <input type="checkbox" name="payment_method[]" value="qris"
                                            class="h-5 w-5 text-primary focus:ring-primary rounded">
                                        <div class="ml-3 flex items-center justify-between flex-1">
                                            <span class="text-sm font-medium text-gray-900">Other QRIS</span>
                                            <img src="{{ asset('images/payment/qris.png') }}" alt="QRIS"
                                                class="h-7">
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <input id="terms" name="terms" type="checkbox"
                                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded" required>
                                <label for="terms" class="ml-2 block text-xs text-gray-900">
                                    I agree to the <a href="{{ route('legal.terms') }}"
                                        class="text-primary hover:text-primary-dark">Terms of Service</a> and <a
                                        href="{{ route('legal.privacy') }}"
                                        class="text-primary hover:text-primary-dark">Privacy Policy</a>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-20">
                <div class="p-4">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Order Summary</h2>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Subtotal</span>
                            <span class="text-sm text-gray-900 font-medium">Rp
                                {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        @if ($discount > 0)
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Discount</span>
                                <span class="text-sm text-green-600 font-medium">-Rp
                                    {{ number_format($discount, 0, ',', '.') }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Tax (11%)</span>
                            <span class="text-sm text-gray-900 font-medium">Rp
                                {{ number_format($tax, 0, ',', '.') }}</span>
                        </div>

                        <div class="border-t border-gray-200 pt-3 flex justify-between">
                            <span class="text-base font-semibold text-gray-900">Total</span>
                            <span class="text-lg font-bold text-primary">Rp
                                {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pay Now Button (Fixed at bottom) -->
        <div class="fixed bottom-0 left-0 right-0 p-4 bg-white border-t border-gray-200 shadow-lg z-10">
            <button form="payment-form" type="submit"
                class="w-full bg-primary hover:bg-primary-dark text-white py-3 rounded-lg text-base font-semibold transition-colors">
                Pay Now
            </button>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const paymentForm = document.getElementById('payment-form');
                const checkboxes = document.querySelectorAll('input[name="payment_method[]"]');

                paymentForm.addEventListener('submit', function(e) {
                    // Check if at least one payment method is selected
                    const isAnyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

                    if (!isAnyChecked) {
                        e.preventDefault();
                        alert('Please select at least one payment method.');
                        return false;
                    }

                    return true;
                });

                // Pre-select first payment method as default
                if (checkboxes.length > 0 && !Array.from(checkboxes).some(checkbox => checkbox.checked)) {
                    checkboxes[0].checked = true;
                }
            });
        </script>
    @endpush
@endsection
