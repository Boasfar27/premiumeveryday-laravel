@extends('pages.desktop.layouts.app')

@section('title', 'Detail Lisensi')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <!-- Hero section with subtle pattern and improved visuals -->
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

            <div class="max-w-7xl mx-auto px-4 py-12 sm:py-16 mt-8 relative">
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
                            class="inline-flex items-center text-sm text-blue-100 hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50 rounded-md px-2 py-1 -ml-2">
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

            <!-- Simple divider with subtle curve -->
            <div class="h-5 bg-gray-50 rounded-t-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-8 sm:py-12">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 animate-fade-in">
                <!-- License status banner with gradient background -->
                <div
                    class="w-full px-6 py-4 
                @if ($license->isActive()) bg-gradient-to-r from-green-500 to-green-600
                @elseif($license->isExpired()) bg-gradient-to-r from-red-500 to-red-600
                @elseif($license->hasReachedMaxActivations()) bg-gradient-to-r from-yellow-500 to-yellow-600
                @else bg-gradient-to-r from-gray-500 to-gray-600 @endif
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
                            <a href="{{ route('licenses.activate', $license) }}" id="activate-button"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-blue-600 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400">
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

                <!-- License Status Banner with Warnings -->
                @if ($license->isActive() && $license->expires_at && $license->expires_at->diffInDays(now()) <= 30)
                    <div class="bg-yellow-50 p-4 rounded-lg mb-6 border border-yellow-100 animate-fade-in">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Peringatan Masa Berlaku</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>
                                        Lisensi produk ini akan berakhir dalam {{ $license->expires_at->diffInDays(now()) }}
                                        hari pada {{ $license->expires_at->format('d M Y') }}.
                                        @if ($license->digitalProduct->purchaseUrl)
                                            <a href="{{ $license->digitalProduct->purchaseUrl }}"
                                                class="font-medium text-yellow-800 underline hover:text-yellow-600">
                                                Perpanjang sekarang
                                            </a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif ($license->hasReachedMaxActivations())
                    <div class="bg-yellow-50 p-4 rounded-lg mb-6 border border-yellow-100 animate-fade-in">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Batas Aktivasi Tercapai</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>
                                        Lisensi ini telah mencapai batas maksimum aktivasi
                                        ({{ $license->activation_count }}/{{ $license->max_activations }}).
                                        Anda perlu menonaktifkan perangkat yang sudah ada atau hubungi dukungan pelanggan
                                        untuk bantuan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif ($license->isExpired())
                    <div class="bg-red-50 p-4 rounded-lg mb-6 border border-red-100 animate-fade-in">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Lisensi Telah Kadaluarsa</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p>
                                        Lisensi produk ini telah kadaluarsa pada
                                        {{ $license->expires_at->format('d M Y') }}.
                                        @if ($license->digitalProduct->purchaseUrl)
                                            <a href="{{ $license->digitalProduct->purchaseUrl }}"
                                                class="font-medium text-red-800 underline hover:text-red-600">
                                                Beli yang baru
                                            </a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="px-6 py-5 border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-20 w-20 relative">
                            <img class="h-20 w-20 rounded-lg object-cover shadow-sm"
                                src="{{ $license->digitalProduct->thumbnail_url }}"
                                alt="{{ $license->digitalProduct->name }}"
                                onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}';">

                            <div class="absolute -right-1 -bottom-1">
                                @if ($license->isActive())
                                    <span class="flex h-4 w-4">
                                        <span
                                            class="relative inline-flex rounded-full h-4 w-4 bg-green-500 border-2 border-white"></span>
                                    </span>
                                @elseif($license->isExpired())
                                    <span class="flex h-4 w-4">
                                        <span
                                            class="relative inline-flex rounded-full h-4 w-4 bg-red-500 border-2 border-white"></span>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="ml-5">
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

                <div class="px-6 py-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Informasi Lisensi</h3>

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 gap-6">
                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                                <h4 class="text-sm font-medium text-gray-500 mb-2">Kunci Lisensi</h4>
                                <div class="flex items-center">
                                    <div id="license-key-container" class="relative flex-1 group">
                                        <code
                                            class="text-sm bg-white border border-gray-200 px-4 py-3 rounded-md w-full block overflow-x-auto font-mono">
                                            {{ $license->license_key }}
                                        </code>
                                        <div id="masked-key"
                                            class="absolute inset-0 flex items-center px-4 py-3 bg-white border border-gray-200 rounded-md cursor-pointer">
                                            <span
                                                class="font-mono text-sm">{{ substr($license->license_key, 0, 6) }}•••••••••••••••••{{ substr($license->license_key, -6) }}</span>
                                            <span class="text-xs text-gray-400 ml-2">Klik untuk menampilkan</span>
                                        </div>
                                    </div>
                                    <button onclick="copyToClipboard('{{ $license->license_key }}')"
                                        class="ml-3 text-gray-400 hover:text-gray-600 flex-shrink-0 p-2 rounded-full hover:bg-gray-100 transition-colors"
                                        aria-label="Salin kunci lisensi" title="Salin kunci lisensi">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                                <h4 class="text-sm font-medium text-gray-500 mb-2">Status</h4>
                                <div class="flex items-center">
                                    @if ($license->isActive())
                                        <div class="h-3 w-3 rounded-full bg-green-500 mr-2.5"></div>
                                        <span class="text-green-600 font-medium">Aktif</span>
                                    @elseif($license->isExpired())
                                        <div class="h-3 w-3 rounded-full bg-red-500 mr-2.5"></div>
                                        <span class="text-red-600 font-medium">Kadaluarsa</span>
                                    @elseif($license->hasReachedMaxActivations())
                                        <div class="h-3 w-3 rounded-full bg-yellow-500 mr-2.5"></div>
                                        <span class="text-yellow-600 font-medium">Batas Aktivasi Tercapai</span>
                                    @else
                                        <div class="h-3 w-3 rounded-full bg-gray-400 mr-2.5"></div>
                                        <span class="text-gray-600 font-medium">{{ ucfirst($license->status) }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                                <h4 class="text-sm font-medium text-gray-500 mb-2">Pertama Kali Diaktifkan</h4>
                                <div class="text-sm text-gray-900">
                                    @if ($license->activated_at)
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500 mr-1.5"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $license->activated_at->format('d M Y, H:i') }}
                                        </div>
                                    @else
                                        <span class="text-gray-400 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Belum diaktifkan
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                                <h4 class="text-sm font-medium text-gray-500 mb-2">Masa Berlaku</h4>
                                <div
                                    class="text-sm
                                @if ($license->expires_at && $license->isExpired()) text-red-600 
                                @elseif(!$license->expires_at) text-green-600
                                @else text-gray-900 @endif flex items-start">
                                    @if ($license->expires_at)
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 mr-1.5 mt-0.5 flex-shrink-0" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div>
                                            {{ $license->expires_at->format('d M Y') }}
                                            @if ($license->isExpired())
                                                <div class="text-xs text-red-500 mt-0.5">(Telah Kadaluarsa)</div>
                                            @else
                                                <div class="text-xs text-gray-500 mt-0.5">
                                                    ({{ now()->diffInDays($license->expires_at, false) }} hari lagi)</div>
                                            @endif
                                        </div>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 mr-1.5 mt-0.5 flex-shrink-0 text-green-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>Selamanya</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="text-sm font-medium text-gray-500">Aktivasi</h4>
                                <div class="text-sm font-medium">
                                    <span>{{ $license->activation_count }}</span>
                                    <span class="text-gray-400 mx-1">/</span>
                                    <span>{{ $license->max_activations ?: '∞' }}</span>
                                </div>
                            </div>

                            <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                                <div class="bg-blue-600 h-2 rounded-full transition-all duration-500"
                                    style="width: {{ $license->max_activations ? min(100, ($license->activation_count / $license->max_activations) * 100) : 10 }}%">
                                </div>
                            </div>

                            <div class="flex justify-between text-xs text-gray-500">
                                <span>Digunakan: {{ $license->activation_count }}</span>
                                @if ($license->max_activations)
                                    <span>Tersisa:
                                        {{ max(0, $license->max_activations - $license->activation_count) }}</span>
                                @else
                                    <span>Tidak terbatas</span>
                                @endif
                            </div>

                            @if ($license->hasReachedMaxActivations())
                                <div class="mt-3 flex items-center text-yellow-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="font-medium">Lisensi ini telah mencapai batas maksimum aktivasi</span>
                                </div>
                            @endif
                        </div>

                        @if ($license->notes)
                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                                <h4 class="text-sm font-medium text-gray-500 mb-2">Catatan</h4>
                                <div class="text-sm text-gray-900 prose prose-sm max-w-none">
                                    {{ $license->notes }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="px-6 py-5 bg-gray-50 border-t border-gray-100">
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-3">
                            <a href="{{ route('licenses.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Kembali
                            </a>

                            <button onclick="window.print()"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Cetak
                            </button>
                        </div>

                        @if ($license->isActive() && !$license->hasReachedMaxActivations())
                            <a href="{{ route('licenses.activate', $license) }}" id="desktop-activate-button"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Aktivasi Lisensi
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast notification -->
    <div id="toast" class="fixed inset-x-0 bottom-0 pb-6 sm:pb-8 pointer-events-none z-50 flex justify-center">
        <div
            class="transform transition-all duration-300 opacity-0 translate-y-12 max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto overflow-hidden">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg id="toast-icon-success" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <svg id="toast-icon-error" class="h-6 w-6 text-red-400 hidden" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <p id="toast-message" class="text-sm font-medium text-gray-900"></p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button onclick="hideToast()" class="inline-flex text-gray-400 hover:text-gray-500">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show/hide license key
        document.addEventListener('DOMContentLoaded', function() {
            const maskedKey = document.getElementById('masked-key');
            const licenseKeyContainer = document.getElementById('license-key-container');

            if (maskedKey) {
                maskedKey.addEventListener('click', function() {
                    maskedKey.classList.add('hidden');
                });
            }

            // Add click event to activate buttons to show loading state
            const activateButtons = [
                document.getElementById('activate-button'),
                document.getElementById('desktop-activate-button')
            ];

            activateButtons.forEach(button => {
                if (button) {
                    button.addEventListener('click', function(e) {
                        // Don't add loading state if it's just being used to capture the href
                        if (e.ctrlKey || e.metaKey || e.shiftKey) return;

                        const originalText = this.innerHTML;
                        this.innerHTML = `
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Mengaktivasi...
                        `;
                        this.disabled = true;
                        this.classList.add('opacity-75', 'cursor-wait');
                    });
                }
            });
        });

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                showToast('Kunci lisensi berhasil disalin!', 'success');
            }, function() {
                showToast('Gagal menyalin kunci lisensi.', 'error');
            });
        }

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            const successIcon = document.getElementById('toast-icon-success');
            const errorIcon = document.getElementById('toast-icon-error');

            toastMessage.textContent = message;

            if (type === 'success') {
                successIcon.classList.remove('hidden');
                errorIcon.classList.add('hidden');
            } else {
                successIcon.classList.add('hidden');
                errorIcon.classList.remove('hidden');
            }

            // Show toast
            const toastElement = toast.firstElementChild;
            toastElement.classList.remove('opacity-0', 'translate-y-12');

            // Hide after 3 seconds
            setTimeout(hideToast, 3000);
        }

        function hideToast() {
            const toast = document.getElementById('toast');
            const toastElement = toast.firstElementChild;
            toastElement.classList.add('opacity-0', 'translate-y-12');
        }
    </script>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media print {

            .bg-gradient-to-r,
            .bg-gray-50 {
                background: white !important;
                color: black !important;
            }

            .text-white {
                color: black !important;
            }

            a,
            button {
                display: none !important;
            }

            #masked-key {
                display: none !important;
            }
        }
    </style>
@endsection
