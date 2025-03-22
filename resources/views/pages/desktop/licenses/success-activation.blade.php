@extends('pages.desktop.layouts.app')

@section('title', 'Aktivasi Sukses')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <!-- Hero section -->
        <div class="relative overflow-hidden bg-gradient-to-r from-green-600 to-green-700 text-white">
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
                <div class="flex justify-center mb-5">
                    <div class="bg-white rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div class="text-center md:w-2/3 mx-auto">
                    <h1 class="text-3xl sm:text-4xl font-bold tracking-tight mb-3 drop-shadow-sm">
                        Aktivasi Berhasil!
                    </h1>

                    <div class="h-1 w-24 bg-green-400 mb-4 rounded-full mx-auto"></div>

                    <p class="text-green-100 text-lg mb-4 max-w-xl mx-auto">
                        Lisensi untuk {{ $license->digitalProduct->name }} telah berhasil diaktifkan untuk perangkat <span
                            class="font-medium">{{ $activation->device_name }}</span>.
                    </p>

                    <div class="flex justify-center mt-6">
                        <a href="{{ route('licenses.show', $license) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-green-700 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Lihat Detail Lisensi
                        </a>
                    </div>
                </div>
            </div>

            <!-- Simple divider instead of wave -->
            <div class="h-5 bg-gray-50 rounded-t-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100 max-w-3xl mx-auto">
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
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Lisensi Aktif
                                </span>
                                <span class="mx-2">•</span>
                                <span>Kunci:
                                    {{ substr($license->license_key, 0, 8) }}...{{ substr($license->license_key, -8) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-5">
                    <div class="mb-5">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Aktivasi</h3>

                        <div class="rounded-md bg-green-50 p-4 mb-5">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-green-800">Aktivasi Berhasil</h3>
                                    <div class="mt-2 text-sm text-green-700">
                                        <p>Lisensi ini telah diaktifkan pada perangkat {{ $activation->device_name }} pada
                                            {{ $activation->created_at->format('d F Y, H:i') }}.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Perangkat</h4>
                                <div class="text-sm text-gray-900 font-medium">
                                    {{ $activation->device_name }}
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Waktu Aktivasi</h4>
                                <div class="text-sm text-gray-900">
                                    {{ $activation->created_at->format('d F Y, H:i') }}
                                </div>
                            </div>
                        </div>

                        @if ($activation->notes)
                            <div class="bg-gray-50 rounded-lg p-4 mt-4">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Catatan</h4>
                                <div class="text-sm text-gray-900">
                                    {{ $activation->notes }}
                                </div>
                            </div>
                        @endif

                        <div class="mt-5">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Informasi Lisensi</h4>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h5 class="text-xs font-medium text-gray-500 mb-1">Aktivasi</h5>
                                    <div class="text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{ $license->activation_count }}</span>
                                            <span class="mx-1">/</span>
                                            <span>{{ $license->max_activations ?: '∞' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h5 class="text-xs font-medium text-gray-500 mb-1">Pertama Kali Diaktifkan</h5>
                                    <div class="text-sm text-gray-900">
                                        {{ $license->activated_at->format('d M Y') }}
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h5 class="text-xs font-medium text-gray-500 mb-1">Masa Berlaku</h5>
                                    <div class="text-sm text-gray-900">
                                        @if ($license->expires_at)
                                            {{ $license->expires_at->format('d M Y') }}
                                        @else
                                            Selamanya
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    <div class="flex justify-center sm:justify-between flex-wrap">
                        <a href="{{ route('licenses.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mb-2 sm:mb-0 w-full sm:w-auto justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            Kembali ke Daftar Lisensi
                        </a>

                        <a href="{{ route('licenses.show', $license) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 w-full sm:w-auto justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Lihat Detail Lisensi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
