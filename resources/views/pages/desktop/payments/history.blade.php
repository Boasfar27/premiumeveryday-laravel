@extends('pages.desktop.layouts.app')

@section('content')
    <div class="py-12 bg-gray-100 mt-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg mb-6">
                <div class="p-8 border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-900">Payment History</h1>
                    <p class="mt-2 text-gray-600">Track and manage all your payment transactions</p>
                </div>

                @if (session('success'))
                    <div class="mx-8 mt-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mx-8 mt-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="p-8">
                    @if ($payments->isEmpty())
                        <div class="text-center py-16">
                            <svg class="h-20 w-20 text-gray-400 mx-auto mb-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                            <h2 class="text-xl font-medium text-gray-900 mb-4">No payment records found</h2>
                            <p class="text-gray-600 max-w-md mx-auto mb-6">You haven't made any payments yet. Browse our
                                products and make a purchase to see your payment history here.</p>
                            <a href="{{ route('products.index') }}"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                Browse Products
                            </a>
                        </div>
                    @else
                        <div class="grid gap-6">
                            @foreach ($payments as $payment)
                                <div
                                    class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                    <div class="grid grid-cols-12 gap-4 px-6 py-4">
                                        <div class="col-span-2">
                                            <div class="text-sm font-medium text-gray-500 mb-1">Transaction ID</div>
                                            <div class="text-sm font-semibold text-gray-900 truncate">
                                                {{ $payment->transaction_id ?? 'N/A' }}</div>
                                        </div>

                                        <div class="col-span-2">
                                            <div class="text-sm font-medium text-gray-500 mb-1">Date</div>
                                            <div class="text-sm font-medium text-gray-700">
                                                {{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') : '-' }}
                                            </div>
                                        </div>

                                        <div class="col-span-2">
                                            <div class="text-sm font-medium text-gray-500 mb-1">Method</div>
                                            <div class="text-sm font-medium text-gray-700">
                                                {{ $payment->payment_method ?? 'N/A' }}</div>
                                        </div>

                                        <div class="col-span-2">
                                            <div class="text-sm font-medium text-gray-500 mb-1">Amount</div>
                                            <div class="text-base font-bold text-gray-900">Rp
                                                {{ number_format($payment->amount ?? 0, 0, ',', '.') }}</div>
                                        </div>

                                        <div class="col-span-2">
                                            <div class="text-sm font-medium text-gray-500 mb-1">Order</div>
                                            <div class="text-sm font-medium text-gray-700">
                                                @if ($payment->order_id)
                                                    <a href="{{ url('/user/orders/' . $payment->order_id) }}"
                                                        class="text-primary hover:text-primary-dark hover:underline">
                                                        #{{ $payment->order_id }}
                                                    </a>
                                                @else
                                                    N/A
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-span-2">
                                            <div class="text-sm font-medium text-gray-500 mb-1">Status</div>
                                            @php
                                                $statusColor = match ($payment->status ?? 'unknown') {
                                                    'pending' => 'yellow',
                                                    'processing' => 'blue',
                                                    'completed' => 'green',
                                                    'failed' => 'red',
                                                    'refunded' => 'purple',
                                                    default => 'gray',
                                                };
                                            @endphp
                                            <span
                                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800">
                                                {{ ucfirst($payment->status ?? 'Unknown') }}
                                            </span>
                                        </div>
                                    </div>

                                    @if ($payment->notes)
                                        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200 text-sm text-gray-600">
                                            <span class="font-medium">Notes:</span> {{ $payment->notes }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $payments->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Script tetap dibiarkan untuk referensi di masa mendatang jika dibutuhkan
    </script>
@endpush
