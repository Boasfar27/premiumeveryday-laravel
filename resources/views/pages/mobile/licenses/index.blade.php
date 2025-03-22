@extends('pages.mobile.layouts.app')

@section('title', 'Lisensi Saya')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <!-- Hero section -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-6">
            <div class="mb-2">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-800 bg-opacity-50 text-blue-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
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

        <div class="px-4 py-6">
            @if ($licenses->isEmpty())
                <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mx-auto mb-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <h2 class="text-lg font-medium text-gray-900 mb-2">Belum ada lisensi</h2>
                    <p class="text-gray-500 mb-4">
                        Anda belum memiliki lisensi produk. Beli produk digital premium untuk mendapatkan lisensi.
                    </p>
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Lihat Produk
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($licenses as $license)
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
                            <div class="flex items-center p-4 border-b border-gray-100">
                                <div class="flex-shrink-0 h-12 w-12">
                                    <img class="h-12 w-12 rounded-lg object-cover"
                                        src="{{ $license->digitalProduct->thumbnail_url }}"
                                        alt="{{ $license->digitalProduct->name }}"
                                        onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}';">
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
                                        <code class="bg-gray-100 px-2 py-1 rounded">
                                            {{ substr($license->license_key, 0, 5) }}...{{ substr($license->license_key, -5) }}
                                        </code>
                                        <button onclick="copyToClipboard('{{ $license->license_key }}')"
                                            class="ml-2 text-gray-400 hover:text-gray-600">
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
                                    <span class="text-gray-900 font-medium">
                                        {{ $license->activation_count }} / {{ $license->max_activations ?: '∞' }}
                                    </span>
                                </div>
                            </div>

                            <div class="px-4 py-3 flex justify-between border-t border-gray-100">
                                <a href="{{ route('licenses.show', $license) }}" class="text-blue-600 text-sm font-medium">
                                    Detail
                                </a>
                                @if ($license->isActive() && !$license->hasReachedMaxActivations())
                                    <a href="{{ route('licenses.activate', $license) }}"
                                        class="text-green-600 text-sm font-medium">
                                        Aktivasi
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
