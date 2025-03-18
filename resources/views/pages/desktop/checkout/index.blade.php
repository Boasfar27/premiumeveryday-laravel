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
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Pembayaran</h2>

                            <form action="{{ route('process.payment') }}" method="POST" id="payment-form">
                                @csrf
                                <div class="space-y-4">
                                    <!-- Payment Information -->
                                    <div class="p-4 bg-blue-50 rounded-md">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-blue-800">Informasi Pembayaran</h3>
                                                <div class="mt-2 text-sm text-blue-700">
                                                    <p class="mb-1">Setelah mengklik "Bayar Sekarang", Anda akan diarahkan
                                                        ke halaman pembayaran Midtrans yang aman.</p>
                                                    <p>Di halaman Midtrans, Anda dapat memilih metode pembayaran yang Anda
                                                        inginkan seperti Virtual Account, QRIS, GoPay, dan lainnya.</p>
                                                </div>
                                            </div>
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
                                        Bayar Sekarang
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
                // Form validation logic if needed can be added here
            });
        </script>
    @endpush
@endsection
