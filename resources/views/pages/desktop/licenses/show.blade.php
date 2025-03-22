@extends('pages.desktop.layouts.app')

@section('title', 'Detail Lisensi')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <!-- Hero section -->
        <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 to-blue-700 text-white">
            <!-- Background pattern -->
            <div class="absolute inset-0 opacity-10">
                <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0,0 L100,0 L100,100 L0,100 Z" fill="url(#grid)" />
                    <defs>
                        <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                            <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5" />
                        </pattern>
                    </defs>
                </svg>
            </div>

            <div class="max-w-7xl mx-auto px-4 py-12 mt-8 relative">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-800 bg-opacity-50 text-blue-100 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                            clip-rule="evenodd" />
                    </svg>
                    DETAIL LISENSI
                </span>

                <div class="md:w-2/3 xl:w-1/2">
                    <h1 class="text-3xl sm:text-4xl font-bold tracking-tight mb-3 drop-shadow-sm">
                        {{ $license->digitalProduct->name }}
                    </h1>

                    <div class="h-1 w-24 bg-blue-400 mb-4 rounded-full"></div>

                    <p class="text-blue-100 text-lg mb-4 max-w-xl">
                        Detail dan informasi lisensi untuk produk digital Anda.
                    </p>

                    <div class="flex items-center">
                        <a href="{{ route('licenses.index') }}"
                            class="inline-flex items-center text-sm text-blue-100 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Kembali ke Daftar Lisensi
                        </a>
                    </div>
                </div>
            </div>

            <!-- Simple divider instead of wave -->
            <div class="h-5 bg-gray-50 rounded-t-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
                <!-- License status banner -->
                <div
                    class="w-full px-6 py-3 
                @if ($license->isActive()) bg-green-500 
                @elseif($license->isExpired()) bg-red-500 
                @elseif($license->hasReachedMaxActivations()) bg-yellow-500 
                @else bg-gray-500 @endif
                text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            @if ($license->isActive())
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">Lisensi Aktif</span>
                            @elseif($license->isExpired())
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">Lisensi Kadaluarsa</span>
                            @elseif($license->hasReachedMaxActivations())
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">Batas Aktivasi Tercapai</span>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">{{ ucfirst($license->status) }}</span>
                            @endif
                        </div>

                        @if ($license->isActive() && !$license->hasReachedMaxActivations())
                            <a href="{{ route('licenses.activate', $license) }}"
                                class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-blue-600 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                                Aktivasi
                            </a>
                        @endif
                    </div>
                </div>

                <div class="px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-16 w-16">
                            <img class="h-16 w-16 rounded-lg object-cover"
                                src="{{ $license->digitalProduct->thumbnail_url }}"
                                alt="{{ $license->digitalProduct->name }}"
                                onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}';">
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-medium text-gray-900">
                                {{ $license->digitalProduct->name }}
                            </h2>
                            <div class="mt-1 flex items-center text-sm text-gray-500">
                                <span>Dibeli pada {{ $license->created_at->format('d M Y') }}</span>
                                <span class="mx-2">•</span>
                                <span>Order #{{ $license->order->order_number }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Lisensi</h3>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Kunci Lisensi</h4>
                                <div class="flex items-center">
                                    <code
                                        class="text-sm bg-white border border-gray-200 px-3 py-2 rounded-md w-full overflow-x-auto">
                                        {{ $license->license_key }}
                                    </code>
                                    <button onclick="copyToClipboard('{{ $license->license_key }}')"
                                        class="ml-2 text-gray-400 hover:text-gray-600 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Status</h4>
                                <div class="text-sm text-gray-900">
                                    @if ($license->isActive())
                                        <span class="text-green-600 font-medium">Aktif</span>
                                    @elseif($license->isExpired())
                                        <span class="text-red-600 font-medium">Kadaluarsa</span>
                                    @elseif($license->hasReachedMaxActivations())
                                        <span class="text-yellow-600 font-medium">Batas Aktivasi Tercapai</span>
                                    @else
                                        <span class="text-gray-600 font-medium">{{ ucfirst($license->status) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Pertama Kali Diaktifkan</h4>
                                <div class="text-sm text-gray-900">
                                    @if ($license->activated_at)
                                        {{ $license->activated_at->format('d M Y, H:i') }}
                                    @else
                                        <span class="text-gray-400">Belum diaktifkan</span>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Masa Berlaku</h4>
                                <div
                                    class="text-sm 
                                @if ($license->expires_at && $license->isExpired()) text-red-600 
                                @elseif(!$license->expires_at) text-green-600
                                @else text-gray-900 @endif">
                                    @if ($license->expires_at)
                                        {{ $license->expires_at->format('d M Y') }}
                                        @if ($license->isExpired())
                                            (Kadaluarsa)
                                        @endif
                                    @else
                                        Selamanya
                                    @endif
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Aktivasi</h4>
                                <div class="text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{ $license->activation_count }}</span>
                                        <span class="mx-1">/</span>
                                        <span>{{ $license->max_activations ?: '∞' }}</span>

                                        @if ($license->hasReachedMaxActivations())
                                            <span
                                                class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Maksimum
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($license->notes)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Catatan</h4>
                                <div class="text-sm text-gray-900">
                                    {{ $license->notes }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('licenses.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali
                        </a>

                        @if ($license->isActive() && !$license->hasReachedMaxActivations())
                            <a href="{{ route('licenses.activate', $license) }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                </svg>
                                Aktivasi Lisensi
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Kunci lisensi berhasil disalin!');
            }, function() {
                alert('Gagal menyalin kunci lisensi.');
            });
        }
    </script>
@endsection
