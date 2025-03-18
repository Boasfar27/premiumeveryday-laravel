@extends('pages.mobile.layouts.app')

@section('content')
    <div class="bg-gray-100 min-h-screen pb-12">
        <div class="bg-white shadow">
            <div class="px-4 py-5">
                <div class="flex items-center">
                    <a href="{{ route('user.payments.history') }}" class="mr-2">
                        <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </a>
                    <h1 class="text-xl font-semibold text-gray-900">Detail Pembayaran</h1>
                </div>
                <p class="mt-1 text-sm text-gray-600">No. Pembayaran #{{ $order->order_number }}</p>
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

            @if (session('info'))
                <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded">
                    {{ session('info') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow mb-5">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg font-medium text-gray-900">Informasi Pembayaran</h2>
                    <span
                        class="px-2 py-1 text-xs font-semibold rounded-full bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-800">
                        {{ $order->getFormattedStatusAttribute() }}
                    </span>
                </div>

                <div class="p-4">
                    <dl class="space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <dt class="text-sm font-medium text-gray-500">Tanggal</dt>
                            <dd class="text-sm text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</dd>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <dt class="text-sm font-medium text-gray-500">Total</dt>
                            <dd class="text-sm text-gray-900 font-semibold">{{ $order->getFormattedTotalAttribute() }}</dd>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <dt class="text-sm font-medium text-gray-500">Metode Pembayaran</dt>
                            <dd class="text-sm text-gray-900">{{ $order->payment_method ?? 'Bank Transfer' }}</dd>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <dt class="text-sm font-medium text-gray-500">Status Pembayaran</dt>
                            <dd class="text-sm text-gray-900">{{ $order->payment_status ?? 'Pending' }}</dd>
                        </div>

                        @if ($order->coupon_code)
                            <div class="grid grid-cols-2 gap-3">
                                <dt class="text-sm font-medium text-gray-500">Kode Kupon</dt>
                                <dd class="text-sm text-gray-900">{{ $order->coupon_code }}</dd>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <dt class="text-sm font-medium text-gray-500">Diskon</dt>
                                <dd class="text-sm text-gray-900">Rp
                                    {{ number_format($order->discount_amount, 0, ',', '.') }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            @if ($order->payment_method == 'midtrans' && $order->midtransTransaction)
                <div class="bg-white rounded-lg shadow mb-5">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Detail Transaksi</h2>
                    </div>
                    <div class="p-4">
                        <dl class="space-y-3">
                            @if ($order->midtransTransaction->transaction_id)
                                <div class="grid grid-cols-2 gap-3">
                                    <dt class="text-sm font-medium text-gray-500">ID Transaksi</dt>
                                    <dd class="text-sm text-gray-900">{{ $order->midtransTransaction->transaction_id }}
                                    </dd>
                                </div>
                            @endif

                            @if ($order->midtransTransaction->payment_type)
                                <div class="grid grid-cols-2 gap-3">
                                    <dt class="text-sm font-medium text-gray-500">Tipe Pembayaran</dt>
                                    <dd class="text-sm text-gray-900">
                                        {{ ucfirst($order->midtransTransaction->payment_type) }}</dd>
                                </div>
                            @endif

                            @if ($order->midtransTransaction->transaction_time)
                                <div class="grid grid-cols-2 gap-3">
                                    <dt class="text-sm font-medium text-gray-500">Waktu Transaksi</dt>
                                    <dd class="text-sm text-gray-900">
                                        {{ $order->midtransTransaction->transaction_time->format('d M Y, H:i') }}</dd>
                                </div>
                            @endif

                            @if ($order->midtransTransaction->transaction_status)
                                <div class="grid grid-cols-2 gap-3">
                                    <dt class="text-sm font-medium text-gray-500">Status Transaksi</dt>
                                    <dd class="text-sm text-gray-900">
                                        @if ($order->midtransTransaction->transaction_status == 'settlement')
                                            <span class="text-green-600 font-medium">Dibayar</span>
                                        @elseif ($order->midtransTransaction->transaction_status == 'pending')
                                            <span class="text-yellow-600 font-medium">Menunggu Pembayaran</span>
                                        @elseif (in_array($order->midtransTransaction->transaction_status, ['deny', 'cancel', 'expire', 'failure']))
                                            <span
                                                class="text-red-600 font-medium">{{ ucfirst($order->midtransTransaction->transaction_status) }}</span>
                                        @else
                                            {{ ucfirst($order->midtransTransaction->transaction_status) }}
                                        @endif
                                    </dd>
                                </div>
                            @endif

                            @if ($order->midtransTransaction->payment_code)
                                <div class="grid grid-cols-2 gap-3">
                                    <dt class="text-sm font-medium text-gray-500">Kode Pembayaran</dt>
                                    <dd class="text-sm font-mono bg-gray-100 p-1 rounded">
                                        {{ $order->midtransTransaction->payment_code }}</dd>
                                </div>
                            @endif

                            @if ($order->midtransTransaction->status_message)
                                <div class="col-span-2 mt-2">
                                    <dt class="text-sm font-medium text-gray-500">Pesan Status</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $order->midtransTransaction->status_message }}</dd>
                                </div>
                            @endif

                            @if ($order->midtransTransaction->pdf_url)
                                <div class="col-span-2 mt-3">
                                    <dt class="text-sm font-medium text-gray-500 mb-2">Instruksi Pembayaran</dt>
                                    <dd>
                                        <a href="{{ $order->midtransTransaction->pdf_url }}" target="_blank"
                                            class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10">
                                                </path>
                                            </svg>
                                            Download Instruksi Pembayaran
                                        </a>
                                    </dd>
                                </div>
                            @endif

                            @if ($order->payment_status == 'pending')
                                <div class="col-span-2 mt-3 pt-3 border-t border-gray-200">
                                    <a href="{{ route('payment.midtrans.check', $order->id) }}"
                                        class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Cek Status Pembayaran
                                    </a>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow mb-5">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Item Pembelian</h2>
                </div>

                <div class="divide-y divide-gray-200">
                    @foreach ($order->items as $item)
                        <div class="p-4">
                            <div class="flex justify-between mb-1">
                                <h3 class="text-sm font-medium text-gray-900">{{ $item->name }}</h3>
                                <span class="text-sm text-gray-500">x{{ $item->quantity }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Rp
                                    {{ number_format($item->price, 0, ',', '.') }}</span>
                                <span class="text-sm font-medium text-gray-900">Rp
                                    {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="p-4 bg-gray-50">
                    <dl class="space-y-2">
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Subtotal</dt>
                            <dd class="text-sm text-gray-900">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</dd>
                        </div>

                        @if ($order->tax > 0)
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Pajak</dt>
                                <dd class="text-sm text-gray-900">Rp {{ number_format($order->tax, 0, ',', '.') }}</dd>
                            </div>
                        @endif

                        @if ($order->shipping > 0)
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Pengiriman</dt>
                                <dd class="text-sm text-gray-900">Rp {{ number_format($order->shipping, 0, ',', '.') }}
                                </dd>
                            </div>
                        @endif

                        @if ($order->discount_amount > 0)
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Diskon</dt>
                                <dd class="text-sm text-gray-900">- Rp
                                    {{ number_format($order->discount_amount, 0, ',', '.') }}</dd>
                            </div>
                        @endif

                        <div class="flex justify-between pt-2 border-t border-gray-200">
                            <dt class="text-sm font-medium text-gray-900">Total</dt>
                            <dd class="text-sm font-bold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Feedback Section -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Feedback Anda</h2>
                </div>

                <div class="p-4">
                    @if (in_array($order->status, ['completed', 'active']))
                        @if ($feedback)
                            <div class="bg-gray-50 p-4 rounded border border-gray-200">
                                <div class="flex items-center mb-2">
                                    <div class="flex">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $feedback->rating)
                                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                            @else
                                                <svg class="h-5 w-5 text-gray-300" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <span
                                        class="ml-2 text-sm text-gray-600">{{ $feedback->created_at->format('d M Y') }}</span>
                                </div>

                                <p class="text-gray-700">{{ $feedback->content }}</p>

                                <div class="mt-4">
                                    <a href="{{ route('user.payments.feedback.edit', ['order' => $order->id, 'feedback' => $feedback->id]) }}"
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                        Edit Feedback
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-6">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                    </path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada feedback</h3>
                                <p class="mt-1 text-sm text-gray-500">Bagikan pengalaman Anda tentang pesanan ini.</p>
                                <div class="mt-6">
                                    <a href="{{ route('user.payments.feedback.create', $order) }}"
                                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                            </path>
                                        </svg>
                                        Berikan Feedback
                                    </a>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-6">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Feedback belum tersedia</h3>
                            <p class="mt-1 text-sm text-gray-500">Anda dapat memberikan feedback setelah pesanan selesai
                                atau
                                aktif.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
