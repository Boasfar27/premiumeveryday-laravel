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
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Payment Method</h2>

                            <form action="{{ route('process.payment') }}" method="POST" id="payment-form">
                                @csrf
                                <div class="space-y-4">
                                    <!-- Payment Options -->
                                    <div>
                                        <label class="block text-lg font-medium text-gray-900 mb-4">
                                            Select Payment Methods
                                        </label>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <!-- Mandiri VA -->
                                            <label
                                                class="relative flex items-center p-4 border border-gray-300 rounded-md cursor-pointer hover:border-primary hover:bg-gray-50 transition">
                                                <input type="checkbox" name="payment_method[]" value="mandiri_va"
                                                    class="h-5 w-5 text-primary focus:ring-primary rounded">
                                                <div class="ml-3 flex items-center justify-between flex-1">
                                                    <span class="text-base font-medium text-gray-900">Mandiri VA</span>
                                                    <img src="{{ asset('images/payment/mandiri.png') }}" alt="Mandiri VA"
                                                        class="h-8">
                                                </div>
                                            </label>

                                            <!-- BNI VA -->
                                            <label
                                                class="relative flex items-center p-4 border border-gray-300 rounded-md cursor-pointer hover:border-primary hover:bg-gray-50 transition">
                                                <input type="checkbox" name="payment_method[]" value="bni_va"
                                                    class="h-5 w-5 text-primary focus:ring-primary rounded">
                                                <div class="ml-3 flex items-center justify-between flex-1">
                                                    <span class="text-base font-medium text-gray-900">BNI VA</span>
                                                    <img src="{{ asset('images/payment/bni.png') }}" alt="BNI VA"
                                                        class="h-8">
                                                </div>
                                            </label>

                                            <!-- BRI VA -->
                                            <label
                                                class="relative flex items-center p-4 border border-gray-300 rounded-md cursor-pointer hover:border-primary hover:bg-gray-50 transition">
                                                <input type="checkbox" name="payment_method[]" value="bri_va"
                                                    class="h-5 w-5 text-primary focus:ring-primary rounded">
                                                <div class="ml-3 flex items-center justify-between flex-1">
                                                    <span class="text-base font-medium text-gray-900">BRI VA</span>
                                                    <img src="{{ asset('images/payment/bri.png') }}" alt="BRI VA"
                                                        class="h-8">
                                                </div>
                                            </label>

                                            <!-- CIMB VA -->
                                            <label
                                                class="relative flex items-center p-4 border border-gray-300 rounded-md cursor-pointer hover:border-primary hover:bg-gray-50 transition">
                                                <input type="checkbox" name="payment_method[]" value="cimb_va"
                                                    class="h-5 w-5 text-primary focus:ring-primary rounded">
                                                <div class="ml-3 flex items-center justify-between flex-1">
                                                    <span class="text-base font-medium text-gray-900">CIMB VA</span>
                                                    <img src="{{ asset('images/payment/cimb.png') }}" alt="CIMB VA"
                                                        class="h-8">
                                                </div>
                                            </label>

                                            <!-- GO-PAY -->
                                            <label
                                                class="relative flex items-center p-4 border border-gray-300 rounded-md cursor-pointer hover:border-primary hover:bg-gray-50 transition">
                                                <input type="checkbox" name="payment_method[]" value="gopay"
                                                    class="h-5 w-5 text-primary focus:ring-primary rounded">
                                                <div class="ml-3 flex items-center justify-between flex-1">
                                                    <span class="text-base font-medium text-gray-900">GO-PAY</span>
                                                    <img src="{{ asset('images/payment/gopay.png') }}" alt="GO-PAY"
                                                        class="h-8">
                                                </div>
                                            </label>

                                            <!-- Permata VA -->
                                            <label
                                                class="relative flex items-center p-4 border border-gray-300 rounded-md cursor-pointer hover:border-primary hover:bg-gray-50 transition">
                                                <input type="checkbox" name="payment_method[]" value="permata_va"
                                                    class="h-5 w-5 text-primary focus:ring-primary rounded">
                                                <div class="ml-3 flex items-center justify-between flex-1">
                                                    <span class="text-base font-medium text-gray-900">Permata VA</span>
                                                    <img src="{{ asset('images/payment/permata.png') }}" alt="Permata VA"
                                                        class="h-8">
                                                </div>
                                            </label>

                                            <!-- Other VA -->
                                            <label
                                                class="relative flex items-center p-4 border border-gray-300 rounded-md cursor-pointer hover:border-primary hover:bg-gray-50 transition">
                                                <input type="checkbox" name="payment_method[]" value="other_va"
                                                    class="h-5 w-5 text-primary focus:ring-primary rounded">
                                                <div class="ml-3 flex items-center justify-between flex-1">
                                                    <span class="text-base font-medium text-gray-900">Other VA</span>
                                                    <img src="{{ asset('images/payment/other_bank.png') }}"
                                                        alt="Other VA" class="h-8">
                                                </div>
                                            </label>

                                            <!-- Other QRIS -->
                                            <label
                                                class="relative flex items-center p-4 border border-gray-300 rounded-md cursor-pointer hover:border-primary hover:bg-gray-50 transition">
                                                <input type="checkbox" name="payment_method[]" value="qris"
                                                    class="h-5 w-5 text-primary focus:ring-primary rounded">
                                                <div class="ml-3 flex items-center justify-between flex-1">
                                                    <span class="text-base font-medium text-gray-900">Other QRIS</span>
                                                    <img src="{{ asset('images/payment/qris.png') }}" alt="QRIS"
                                                        class="h-8">
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="flex items-center">
                                        <input id="terms" name="terms" type="checkbox"
                                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded"
                                            required>
                                        <label for="terms" class="ml-2 block text-sm text-gray-900">
                                            I agree to the <a href="{{ route('legal.terms') }}"
                                                class="text-primary hover:text-primary-dark">Terms of Service</a> and <a
                                                href="{{ route('legal.privacy') }}"
                                                class="text-primary hover:text-primary-dark">Privacy Policy</a>
                                        </label>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <button type="submit"
                                        class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-3 px-4 rounded transition">
                                        Pay Now
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden sticky top-24">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h2>

                            <div class="space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="text-gray-900 font-medium">Rp
                                        {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>

                                @if ($discount > 0)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Discount</span>
                                        <span class="text-green-600 font-medium">-Rp
                                            {{ number_format($discount, 0, ',', '.') }}</span>
                                    </div>
                                @endif

                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tax (11%)</span>
                                    <span class="text-gray-900 font-medium">Rp
                                        {{ number_format($tax, 0, ',', '.') }}</span>
                                </div>

                                <div class="border-t border-gray-200 pt-4 flex justify-between">
                                    <span class="text-gray-900 font-bold">Total</span>
                                    <span class="text-primary font-bold text-xl">Rp
                                        {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
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
