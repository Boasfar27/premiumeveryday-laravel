@extends('pages.mobile.layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-4">
            <a href="{{ route('user.payments.history') }}"
                class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500">
                <svg class="mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>

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

        @if (session('info'))
            <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded">
                {{ session('info') }}
            </div>
        @endif

        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Detail Pesanan</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">No. Pesanan #{{ $order->order_number }}</p>
                </div>
                <div>
                    {!! $order->getFormattedStatusAttribute() !!}
                </div>
            </div>

            <div class="px-4 py-5">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Pesanan</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $order->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total Pembayaran</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $order->getFormattedTotalAttribute() }}
                            </dd>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Metode Pembayaran</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if ($order->payment_method == 'midtrans')
                                    @if ($order->midtransTransaction && $order->midtransTransaction->payment_type)
                                        @php
                                            $paymentType = $order->midtransTransaction->payment_type;
                                            $paymentTypeLabels = [
                                                'bank_transfer' => 'Transfer Bank',
                                                'credit_card' => 'Kartu Kredit',
                                                'cstore' => 'Convenience Store',
                                                'gopay' => 'GoPay',
                                                'shopeepay' => 'ShopeePay',
                                                'qris' => 'QRIS',
                                                'echannel' => 'Mandiri Bill',
                                                'permata_va' => 'Permata Virtual Account',
                                                'bca_va' => 'BCA Virtual Account',
                                                'bni_va' => 'BNI Virtual Account',
                                                'bri_va' => 'BRI Virtual Account',
                                            ];
                                        @endphp
                                        {{ $paymentTypeLabels[$paymentType] ?? ucfirst(str_replace('_', ' ', $paymentType)) }}
                                    @else
                                        Midtrans Payment Gateway
                                    @endif
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $order->payment_method ?? 'Bank Transfer')) }}
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status Pembayaran</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @php
                                    $statusLabels = [
                                        'pending' => 'Menunggu Pembayaran',
                                        'paid' => 'Sudah Dibayar',
                                        'failed' => 'Pembayaran Gagal',
                                        'expired' => 'Kedaluwarsa',
                                        'refunded' => 'Dana Dikembalikan',
                                    ];
                                    $statusLabel =
                                        $statusLabels[$order->payment_status] ?? ucfirst($order->payment_status);
                                @endphp
                                {{ $statusLabel }}
                            </dd>
                        </div>
                    </div>

                    @if ($order->coupon_code)
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Kode Kupon</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $order->coupon_code }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Diskon</dt>
                                <dd class="mt-1 text-sm text-gray-900">Rp
                                    {{ number_format($order->discount_amount, 0, ',', '.') }}</dd>
                            </div>
                        </div>
                    @endif
                </dl>
            </div>
        </div>

        <!-- Produk yang dibeli -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Produk yang Dibeli</h3>
            </div>
            <div class="px-4 py-5">
                <ul class="divide-y divide-gray-200">
                    @foreach ($order->items as $item)
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    @if ($item->orderable && method_exists($item->orderable, 'getFirstMediaUrl') && $item->orderable->getFirstMediaUrl())
                                        <img class="h-12 w-12 object-cover rounded-md"
                                            src="{{ $item->orderable->getFirstMediaUrl() }}"
                                            alt="{{ $item->orderable->name }}">
                                    @else
                                        <div class="h-12 w-12 rounded-md bg-gray-200 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $item->orderable->name }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $item->subscription_type ?? 'Standard' }}
                                        @if ($item->duration)
                                            ({{ $item->duration }} bulan)
                                        @endif
                                    </p>
                                    <p class="text-sm font-medium text-gray-700 mt-1">
                                        {{ 'Rp ' . number_format($item->price * $item->quantity, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        @if ($order->payment_status == 'pending' || $order->payment_status == 'failed')
            <div class="p-4 mt-6 bg-yellow-50 sm:rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">
                            {{ $order->payment_status == 'pending' ? 'Menunggu Pembayaran' : 'Pembayaran Gagal' }}
                        </h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>
                                {{ $order->payment_status == 'pending' ? 'Pesanan Anda sedang menunggu pembayaran. Silakan lakukan pembayaran untuk melanjutkan proses pesanan.' : 'Pembayaran untuk pesanan ini gagal. Silakan coba lagi.' }}
                            </p>
                        </div>
                        @if ($canRetry)
                            <div class="mt-4">
                                <div class="-mx-2 -my-1.5 flex">
                                    <a href="{{ route('checkout.payment', $order) }}"
                                        class="px-3 py-1.5 bg-yellow-100 text-yellow-800 hover:bg-yellow-200 rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        Bayar Sekarang
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Review section -->
        @if ($order->payment_status == 'paid')
            <div class="p-4 mt-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Ulasan Produk</h3>

                @if ($canReview)
                    @if (isset($review) && $review)
                        <div class="mt-4 bg-gray-50 p-4 rounded-md">
                            <div class="flex-1">
                                <div class="flex items-center mb-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="h-4 w-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                    <span
                                        class="ml-2 text-xs text-gray-600">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-800 mt-2">{{ $review->comment }}</p>

                                <div class="mt-4">
                                    <a href="{{ route('user.payments.review.edit', ['order' => $order->id, 'review' => $review->id]) }}"
                                        class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                        <svg class="mr-1.5 h-4 w-4 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                        Edit Ulasan
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-6">
                            <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada ulasan</h3>
                            <p class="mt-1 text-sm text-gray-500">Bagikan pendapat Anda tentang produk ini.</p>
                            <div class="mt-6">
                                <a href="{{ route('user.payments.review.create', $order) }}"
                                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                        </path>
                                    </svg>
                                    Berikan Ulasan
                                </a>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="text-center py-6">
                        <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum bisa memberikan ulasan</h3>
                        <p class="mt-1 text-sm text-gray-500">Anda dapat memberikan ulasan setelah pesanan diproses.</p>
                    </div>
                @endif
            </div>
        @endif
    </div>
@endsection
