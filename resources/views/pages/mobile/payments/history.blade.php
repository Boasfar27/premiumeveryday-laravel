@extends('pages.mobile.layouts.app')

@section('content')
    <div class="bg-gray-100 min-h-screen pb-12">
        <!-- Header -->
        <div class="bg-white shadow">
            <div class="px-4 py-5">
                <h1 class="text-xl font-semibold text-gray-900">Riwayat Pembayaran</h1>
                <p class="mt-1 text-sm text-gray-600">Daftar pesanan Anda</p>
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

            @if (count($orders) > 0)
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4 rounded" role="alert">
                    <p class="font-bold">Informasi Pesanan</p>
                    <p class="text-sm">Setelah melakukan pembayaran, admin akan memproses pesanan Anda dan mengirimkan
                        produk ke akun Anda. Setelah menerima produk, Anda dapat memberikan ulasan.</p>
                </div>
                <div class="space-y-4">
                    @foreach ($orders as $order)
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                                <div>
                                    <p class="text-xs text-gray-500">No. Pesanan</p>
                                    <p class="text-sm font-medium">{{ $order->order_number }}</p>
                                </div>
                                <div>
                                    {!! $order->getFormattedStatusAttribute() !!}
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="grid grid-cols-2 gap-2 mb-3">
                                    <div>
                                        <p class="text-xs text-gray-500">Tanggal</p>
                                        <p class="text-sm">
                                            {{ $order->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Total</p>
                                        <p class="text-sm font-medium">{{ $order->getFormattedTotalAttribute() }}</p>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('user.payments.detail', $order) }}"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow mt-4">
                    <div class="p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum Ada Pesanan</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Anda belum memiliki pesanan apapun.</p>
                        <div class="mt-6">
                            <a href="{{ route('home') }}"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
