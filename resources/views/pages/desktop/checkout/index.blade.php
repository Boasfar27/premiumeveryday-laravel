@extends('pages.desktop.layouts.app')

@section('title', 'Checkout - Premium Everyday')

@section('content')
    <div class="bg-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Checkout</h1>

            <!-- Proses Checkout Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-between max-w-2xl mx-auto">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium mt-2">Keranjang</span>
                    </div>
                    <div class="flex-1 h-1 mx-2 bg-pink-600"></div>
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium mt-2">Checkout</span>
                    </div>
                    <div class="flex-1 h-1 mx-2 bg-gray-300"></div>
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium mt-2">Pembayaran</span>
                    </div>
                    <div class="flex-1 h-1 mx-2 bg-gray-300"></div>
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium mt-2">Selesai</span>
                    </div>
                </div>
            </div>

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
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Detail Pesanan</h2>

                            <div class="border-b border-gray-200 pb-6 mb-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Pesanan #{{ $orderNumber }}</h3>

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
                                                    {{ $item['duration'] }} {{ Str::plural('Bulan', $item['duration']) }} |
                                                    {{ ucfirst($item['account_type']) }} Account
                                                </p>
                                                <div class="flex justify-between mt-1">
                                                    <span class="text-sm text-gray-600">Jumlah:
                                                        {{ $item['quantity'] }}</span>
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
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Informasi Pelanggan</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Nama</p>
                                        <p class="text-base font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Email</p>
                                        <p class="text-base font-medium text-gray-900">{{ auth()->user()->email }}</p>
                                    </div>
                                    @if (auth()->user()->phone)
                                        <div>
                                            <p class="text-sm text-gray-600">Telepon</p>
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
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Metode Pembayaran</h2>

                            <p class="text-gray-600 mb-4">
                                Dengan mengklik "Buat Pesanan", Anda akan diarahkan ke gateway pembayaran Midtrans yang
                                aman. Di sana,
                                Anda dapat memilih metode pembayaran yang Anda inginkan.
                            </p>

                            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
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
                                            <ul class="list-disc pl-5 space-y-1">
                                                <li>Semua transaksi diproses melalui Midtrans</li>
                                                <li>Pilihan pembayaran termasuk GoPay, QRIS, transfer bank, dan e-wallet
                                                </li>
                                                <li>Pesanan akan diproses setelah pembayaran berhasil</li>
                                                <li>Anda akan menerima email konfirmasi setelah pembayaran</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
                            <form action="{{ route('process.payment') }}" method="POST" class="space-y-6">
                                @csrf
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="terms" name="terms" type="checkbox"
                                            class="h-4 w-4 rounded border-gray-300 text-pink-600 focus:ring-pink-500">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="terms" class="font-medium text-gray-700">Saya setuju dengan</label>
                                        <a href="{{ route('legal.terms') }}" class="text-pink-600 hover:text-pink-700"
                                            target="_blank">Syarat dan Ketentuan</a>
                                        <p class="text-gray-500">Dengan melakukan pemesanan, Anda menyetujui syarat dan
                                            ketentuan kami.</p>
                                    </div>
                                </div>

                                @error('terms')
                                    <div class="text-red-500 text-sm">Anda harus menyetujui syarat dan ketentuan untuk
                                        melanjutkan.</div>
                                @enderror

                                <button type="submit"
                                    class="w-full bg-pink-600 hover:bg-pink-700 text-white py-3 px-4 rounded-md shadow-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                    Buat Pesanan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden sticky top-24">
                        <div class="p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h2>

                            <!-- Price Summary -->
                            <div class="py-6 px-6 bg-gray-50 rounded-lg space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>

                                @if ($discount > 0)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Diskon</span>
                                        <span class="font-medium text-red-500">- Rp
                                            {{ number_format($discount, 0, ',', '.') }}</span>
                                    </div>
                                @endif

                                <div class="flex justify-between pt-4 border-t border-gray-200 mt-4">
                                    <span class="text-gray-800 font-bold">Total</span>
                                    <span class="font-bold text-xl">Rp {{ number_format($total, 0, ',', '.') }}</span>
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
