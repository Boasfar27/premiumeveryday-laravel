@extends('pages.mobile.layouts.app')

@section('content')
    <div class="bg-gray-100 min-h-screen">
        <div class="bg-white shadow">
            <div class="px-4 py-5">
                <h1 class="text-xl font-semibold text-gray-900">My Orders</h1>
                <p class="mt-1 text-sm text-gray-600">View and manage your orders</p>
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

            @if ($orders->isEmpty())
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <svg class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No orders found</h3>
                    <p class="text-gray-600 mb-4">You haven't placed any orders yet.</p>
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark">
                        Browse Products
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($orders as $order)
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="p-4 border-b border-gray-200">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Order ID</span>
                                        <p class="text-sm font-semibold text-gray-900">
                                            #{{ $order->order_number ?? $order->id }}
                                        </p>
                                    </div>
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full 
                                    bg-{{ $order->status_color ?? 'gray' }}-100 
                                    text-{{ $order->status_color ?? 'gray' }}-800">
                                        {{ ucfirst($order->status ?? 'Processing') }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-4 bg-gray-50">
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Date</span>
                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ date('d M Y', strtotime($order->created_at)) }}
                                        </p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Total</span>
                                        <p class="text-sm font-semibold text-gray-900">
                                            Rp {{ number_format($order->total ?? ($order->grand_total ?? 0), 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>

                                <a href="{{ route('user.orders.show', $order->id) }}"
                                    class="w-full block text-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
