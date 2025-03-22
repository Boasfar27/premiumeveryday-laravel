@extends('pages.desktop.layouts.app')

@section('title', 'Lisensi Saya')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <!-- Hero section with subtle pattern -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white relative overflow-hidden">
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

            <div class="max-w-7xl mx-auto px-4 py-16 sm:py-20 mt-8 relative">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-800 bg-opacity-50 text-blue-100 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                            clip-rule="evenodd" />
                    </svg>
                    LISENSI
                </span>

                <div class="md:w-2/3 xl:w-1/2">
                    <h1 class="text-3xl sm:text-4xl font-bold tracking-tight mb-3 drop-shadow-sm">
                        Lisensi Saya
                    </h1>

                    <div class="h-1 w-24 bg-blue-400 mb-4 rounded-full"></div>

                    <p class="text-blue-100 text-lg mb-4 max-w-xl">
                        Kelola dan aktifkan lisensi produk digital yang Anda miliki. Gunakan kunci lisensi untuk
                        mengaktifkan produk Anda.
                    </p>
                </div>
            </div>

            <!-- Simple divider -->
            <div class="h-5 bg-gray-50 rounded-t-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-8 sm:py-12">
            @if ($licenses->isEmpty())
                <div class="bg-white rounded-xl shadow-sm p-8 sm:p-12 text-center animate-fade-in">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-medium text-gray-900 mb-3">Belum ada lisensi</h2>
                    <p class="text-gray-500 mb-6 max-w-md mx-auto">
                        Anda belum memiliki lisensi produk. Beli produk digital premium untuk mendapatkan lisensi.
                    </p>
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Lihat Produk
                    </a>
                </div>
            @else
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg sm:text-xl font-medium text-gray-900">Daftar Lisensi Anda</h2>
                        <p class="text-sm text-gray-500 mt-1">Menampilkan total {{ $licenses->total() }} lisensi produk</p>
                    </div>

                    <div>
                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                            Temukan Produk Lainnya
                        </a>
                    </div>
                </div>

                <!-- Licenses grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($licenses as $license)
                        <div
                            class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition-all duration-200 license-card">
                            <!-- License header with product info -->
                            <div class="p-4 sm:p-5 flex items-center space-x-4">
                                <div class="flex-shrink-0 relative">
                                    <img class="h-16 w-16 rounded-lg object-cover shadow-sm"
                                        src="{{ $license->digitalProduct->thumbnail_url }}"
                                        alt="{{ $license->digitalProduct->name }}"
                                        onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}';">

                                    <!-- Status indicator -->
                                    @if ($license->isActive())
                                        <div
                                            class="absolute -top-1 -right-1 h-3 w-3 rounded-full bg-green-500 border-2 border-white">
                                        </div>
                                    @elseif($license->isExpired())
                                        <div
                                            class="absolute -top-1 -right-1 h-3 w-3 rounded-full bg-red-500 border-2 border-white">
                                        </div>
                                    @elseif($license->hasReachedMaxActivations())
                                        <div
                                            class="absolute -top-1 -right-1 h-3 w-3 rounded-full bg-yellow-500 border-2 border-white">
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-medium text-gray-900 truncate">
                                        {{ $license->digitalProduct->name }}
                                    </h3>
                                    <div class="mt-1 flex items-center text-xs text-gray-500">
                                        <span>{{ $license->created_at->format('d M Y') }}</span>
                                        <span class="mx-1.5">•</span>
                                        <span>Order #{{ $license->order->order_number }}</span>
                                    </div>

                                    <div class="mt-2">
                                        @if ($license->isActive())
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="h-1.5 w-1.5 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                Aktif
                                            </span>
                                        @elseif($license->isExpired())
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <svg class="h-1.5 w-1.5 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                Kadaluarsa
                                            </span>
                                        @elseif($license->hasReachedMaxActivations())
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <svg class="h-1.5 w-1.5 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                Batas Aktivasi
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <svg class="h-1.5 w-1.5 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                {{ ucfirst($license->status) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- License key section -->
                            <div class="px-4 sm:px-5 py-3 bg-gray-50 border-t border-b border-gray-100">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-xs font-medium text-gray-500">Kunci Lisensi:</span>
                                    <div class="flex items-center">
                                        <button onclick="copyToClipboard('{{ $license->license_key }}')"
                                            class="text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-white transition-colors"
                                            aria-label="Salin kunci lisensi" title="Salin kunci lisensi">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="relative">
                                    <code
                                        class="bg-white border border-gray-200 px-3 py-1.5 rounded-md text-xs font-mono block overflow-x-auto whitespace-nowrap">
                                        {{ $license->license_key }}
                                    </code>
                                </div>

                                <!-- License info -->
                                <div class="grid grid-cols-2 gap-3 mt-3">
                                    <div>
                                        <span class="text-xs text-gray-500">Masa Berlaku:</span>
                                        <div class="mt-0.5">
                                            @if ($license->expires_at)
                                                <span
                                                    class="{{ $license->isExpired() ? 'text-red-600' : 'text-gray-900' }} text-xs font-medium">
                                                    {{ $license->expires_at->format('d M Y') }}
                                                </span>
                                            @else
                                                <span class="text-green-600 text-xs font-medium">Selamanya</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div>
                                        <span class="text-xs text-gray-500">Aktivasi:</span>
                                        <div class="mt-0.5 flex items-center">
                                            <div class="w-16 bg-gray-200 rounded-full h-1.5 mr-2">
                                                <div class="bg-blue-600 h-1.5 rounded-full"
                                                    style="width: {{ $license->max_activations ? min(100, ($license->activation_count / $license->max_activations) * 100) : 10 }}%">
                                                </div>
                                            </div>
                                            <span class="text-xs font-medium text-gray-700">
                                                {{ $license->activation_count }}/{{ $license->max_activations ?: '∞' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- License actions -->
                            <div class="px-4 sm:px-5 py-3 flex justify-between items-center">
                                <a href="{{ route('licenses.show', $license) }}"
                                    class="text-blue-600 text-sm font-medium transition-colors hover:text-blue-800">
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Detail
                                    </span>
                                </a>

                                @if ($license->isActive() && !$license->hasReachedMaxActivations())
                                    <a href="{{ route('licenses.activate', $license) }}"
                                        class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Aktivasi
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $licenses->links() }}
                </div>
            @endif
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

        // Add hover effect to license cards
        document.addEventListener('DOMContentLoaded', function() {
            const licenseCards = document.querySelectorAll('.license-card');

            licenseCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.classList.add('transform', 'scale-[1.01]');
                });

                card.addEventListener('mouseleave', function() {
                    this.classList.remove('transform', 'scale-[1.01]');
                });
            });
        });
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

        /* Smooth transition for license cards */
        .license-card {
            transition: all 0.2s ease-in-out;
        }
    </style>
@endsection
