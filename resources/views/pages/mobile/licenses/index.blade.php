@extends('pages.mobile.layouts.app')

@section('title', 'Lisensi Saya')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <!-- Hero section with subtle pattern -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-6 relative overflow-hidden">
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

            <div class="relative">
                <div class="mb-2">
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-800 bg-opacity-50 text-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd" />
                        </svg>
                        LISENSI
                    </span>
                </div>

                <h1 class="text-2xl font-bold mb-2">Lisensi Saya</h1>
                <div class="h-1 w-16 bg-blue-400 mb-3 rounded-full"></div>
                <p class="text-blue-100 text-sm">
                    Kelola dan aktifkan lisensi produk digital yang Anda miliki.
                </p>
            </div>
        </div>

        <div class="px-4 py-6">
            @if ($licenses->isEmpty())
                <div class="bg-white rounded-lg shadow-sm p-6 text-center animate-fade-in">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-medium text-gray-900 mb-2">Belum ada lisensi</h2>
                    <p class="text-gray-500 mb-4">
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
                <div class="space-y-4">
                    @foreach ($licenses as $license)
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100 transition-all hover:shadow-md license-card"
                            data-id="{{ $license->id }}">
                            <div class="flex items-center p-4 border-b border-gray-100">
                                <div class="flex-shrink-0 h-12 w-12 relative">
                                    <img class="h-12 w-12 rounded-lg object-cover"
                                        src="{{ $license->digitalProduct->thumbnail_url }}"
                                        alt="{{ $license->digitalProduct->name }}"
                                        onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}';">
                                    @if ($license->isActive())
                                        <div
                                            class="absolute -top-1 -right-1 h-3 w-3 rounded-full bg-green-500 border-2 border-white">
                                        </div>
                                    @elseif($license->isExpired())
                                        <div
                                            class="absolute -top-1 -right-1 h-3 w-3 rounded-full bg-red-500 border-2 border-white">
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-3 flex-1">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $license->digitalProduct->name }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        Dibeli pada {{ $license->created_at->format('d M Y') }}
                                    </div>
                                </div>
                                @if ($license->isActive())
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @elseif($license->isExpired())
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Kadaluarsa
                                    </span>
                                @elseif($license->hasReachedMaxActivations())
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Batas Aktivasi
                                    </span>
                                @else
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ ucfirst($license->status) }}
                                    </span>
                                @endif
                            </div>

                            <div class="px-4 py-3 bg-gray-50 text-xs">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-500">Kunci Lisensi:</span>
                                    <div class="flex items-center">
                                        <code class="bg-gray-100 px-2 py-1 rounded font-mono text-xs">
                                            {{ substr($license->license_key, 0, 5) }}...{{ substr($license->license_key, -5) }}
                                        </code>
                                        <button onclick="copyToClipboard('{{ $license->license_key }}')"
                                            class="ml-2 text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-white transition-colors"
                                            aria-label="Salin kunci lisensi" title="Salin kunci lisensi">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-500">Masa Berlaku:</span>
                                    @if ($license->expires_at)
                                        <span
                                            class="{{ $license->isExpired() ? 'text-red-600' : 'text-gray-900' }} font-medium">
                                            {{ $license->expires_at->format('d M Y') }}
                                        </span>
                                    @else
                                        <span class="text-green-600 font-medium">Selamanya</span>
                                    @endif
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500">Aktivasi:</span>
                                    <div class="flex items-center">
                                        <div class="w-24 bg-gray-200 rounded-full h-1.5 mr-2">
                                            <div class="bg-blue-600 h-1.5 rounded-full"
                                                style="width: {{ $license->max_activations ? min(100, ($license->activation_count / $license->max_activations) * 100) : 10 }}%">
                                            </div>
                                        </div>
                                        <span class="text-gray-900 font-medium">
                                            {{ $license->activation_count }} / {{ $license->max_activations ?: '∞' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="px-4 py-3 flex justify-between border-t border-gray-100">
                                <a href="{{ route('licenses.show', $license) }}"
                                    class="text-blue-600 text-sm font-medium transition-colors hover:text-blue-800">
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Detail
                                    </span>
                                </a>
                                @if ($license->isActive() && !$license->hasReachedMaxActivations())
                                    <a href="{{ route('licenses.activate', $license) }}"
                                        class="text-green-600 text-sm font-medium transition-colors hover:text-green-800">
                                        <span class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Aktivasi
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-4">
                        {{ $licenses->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Toast notification -->
    <div id="toast"
        class="fixed inset-x-0 bottom-0 px-4 pb-6 pointer-events-none transform transition-all duration-300 opacity-0 translate-y-12">
        <div class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto overflow-hidden">
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
            toast.classList.remove('opacity-0', 'translate-y-12');

            // Hide after 3 seconds
            setTimeout(hideToast, 3000);
        }

        function hideToast() {
            const toast = document.getElementById('toast');
            toast.classList.add('opacity-0', 'translate-y-12');
        }

        // Add touch swipe functionality to license cards
        document.addEventListener('DOMContentLoaded', function() {
            const licenseCards = document.querySelectorAll('.license-card');

            licenseCards.forEach(card => {
                let touchStartX = 0;
                let touchEndX = 0;

                card.addEventListener('touchstart', e => {
                    touchStartX = e.changedTouches[0].screenX;
                }, false);

                card.addEventListener('touchend', e => {
                    touchEndX = e.changedTouches[0].screenX;
                    handleSwipe(card);
                }, false);

                function handleSwipe(card) {
                    const licenseId = card.dataset.id;
                    if (touchEndX < touchStartX - 100) {
                        // Swiped left, show details
                        window.location.href = `/licenses/${licenseId}`;
                    }
                }
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

        /* Add smooth transition for license cards */
        .license-card {
            transition: all 0.2s ease-in-out;
        }

        .license-card:active {
            transform: scale(0.98);
        }
    </style>
@endsection
