@extends('pages.mobile.layouts.app')

@section('content')
    <div class="bg-gray-100 min-h-screen">
        <div class="bg-white shadow">
            <div class="px-4 py-5">
                <h1 class="text-xl font-semibold text-gray-900">Payment History</h1>
                <p class="mt-1 text-sm text-gray-600">View all your payment transactions</p>
            </div>
        </div>

        <div class="px-4 py-6">
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

            @if ($payments->isEmpty())
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <svg class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No payment records found</h3>
                    <p class="text-gray-600 mb-4">You haven't made any payments yet.</p>
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark">
                        Browse Products
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($payments as $payment)
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="p-4 border-b border-gray-200">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Transaction ID</span>
                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ $payment->transaction_id ?? 'N/A' }}</p>
                                    </div>
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @php
$statusColor = match($payment->status ?? 'unknown') {
                                                'pending' => 'yellow',
                                                'processing' => 'blue',
                                                'completed' => 'green',
                                                'failed' => 'red',
                                                'refunded' => 'purple',
                                                default => 'gray',
                                            }; @endphp
                                        bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800">
                                        {{ ucfirst($payment->status ?? 'Unknown') }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-4 bg-gray-50">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Amount</span>
                                        <p class="text-sm font-semibold text-gray-900">Rp
                                            {{ number_format($payment->amount ?? 0, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Date</span>
                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d M Y, H:i') : '-' }}
                                        </p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Method</span>
                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ $payment->payment_method ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Order</span>
                                        <p class="text-sm font-semibold text-gray-900">
                                            @if ($payment->order_id)
                                                <a href="{{ url('/user/orders/' . $payment->order_id) }}"
                                                    class="text-primary hover:underline">
                                                    #{{ $payment->order_id }}
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                @if ($payment->notes)
                                    <div class="mt-4 p-3 bg-gray-100 rounded text-sm text-gray-700">
                                        <span class="font-medium">Notes:</span> {{ $payment->notes }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-6">
                        {{ $payments->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Script tetap dibiarkan untuk referensi di masa mendatang jika dibutuhkan
    </script>
@endpush
