@extends('pages.desktop.layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('user.payments.history') }}"
                class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500">
                <svg class="mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Riwayat Pembayaran
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
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Detail Pembayaran</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">No. Pembayaran #{{ $order->order_number }}</p>
                </div>
                <span
                    class="px-3 py-1 text-xs font-semibold rounded-full bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-800">
                    {{ $order->getFormattedStatusAttribute() }}
                </span>
            </div>

            <div class="px-4 py-5 sm:p-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Tanggal</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</dd>
                    </div>

                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Total</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $order->getFormattedTotalAttribute() }}</dd>
                    </div>

                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Metode Pembayaran</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $order->payment_method ?? 'Bank Transfer' }}</dd>
                    </div>

                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Status Pembayaran</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $order->payment_status ?? 'Pending' }}</dd>
                    </div>

                    @if ($order->coupon_code)
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Kode Kupon</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $order->coupon_code }}</dd>
                        </div>

                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Diskon</dt>
                            <dd class="mt-1 text-sm text-gray-900">Rp
                                {{ number_format($order->discount_amount, 0, ',', '.') }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>

        @if ($order->payment_method == 'midtrans' && $order->midtransTransaction)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Pembayaran</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        @if ($order->midtransTransaction->transaction_id)
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">ID Transaksi</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $order->midtransTransaction->transaction_id }}
                                </dd>
                            </div>
                        @endif

                        @if ($order->midtransTransaction->payment_type)
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Tipe Pembayaran</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ ucfirst($order->midtransTransaction->payment_type) }}</dd>
                            </div>
                        @endif

                        @if ($order->midtransTransaction->transaction_time)
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Waktu Transaksi</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $order->midtransTransaction->transaction_time->format('d M Y, H:i') }}</dd>
                            </div>
                        @endif

                        @if ($order->midtransTransaction->transaction_status)
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Status Transaksi</dt>
                                <dd class="mt-1 text-sm text-gray-900">
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
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Kode Pembayaran</dt>
                                <dd class="mt-1 text-sm font-mono bg-gray-100 p-1 rounded">
                                    {{ $order->midtransTransaction->payment_code }}</dd>
                            </div>
                        @endif

                        @if ($order->midtransTransaction->status_message)
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Pesan Status</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $order->midtransTransaction->status_message }}
                                </dd>
                            </div>
                        @endif

                        @if ($order->midtransTransaction->pdf_url)
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Instruksi Pembayaran</dt>
                                <dd class="mt-1">
                                    <a href="{{ $order->midtransTransaction->pdf_url }}" target="_blank"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
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
                            <div class="sm:col-span-2 pt-2 mt-2 border-t border-gray-200">
                                <a href="{{ route('payment.midtrans.check', $order->id) }}"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
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

        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Item Pembelian</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Produk
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Harga
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subtotal
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $item->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium text-right">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <th scope="row" colspan="3"
                                class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                Subtotal
                            </th>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900 font-medium text-right">
                                Rp {{ number_format($order->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @if ($order->tax > 0)
                            <tr>
                                <th scope="row" colspan="3"
                                    class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                    Pajak
                                </th>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900 font-medium text-right">
                                    Rp {{ number_format($order->tax, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endif
                        @if ($order->shipping > 0)
                            <tr>
                                <th scope="row" colspan="3"
                                    class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                    Pengiriman
                                </th>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900 font-medium text-right">
                                    Rp {{ number_format($order->shipping, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endif
                        @if ($order->discount_amount > 0)
                            <tr>
                                <th scope="row" colspan="3"
                                    class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                    Diskon
                                </th>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900 font-medium text-right">
                                    - Rp {{ number_format($order->discount_amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <th scope="row" colspan="3"
                                class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                Total
                            </th>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900 font-bold text-right">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Order Status -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Order Status</h3>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $order->status }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Payment Status</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $order->payment_status }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Order Date</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $order->created_at->format('d M Y H:i') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
@endsection
