@extends('pages.mobile.layouts.app')

@section('title', 'Aktivasi Sukses')

@section('content')
    <div class="bg-gray-50 min-h-screen pb-12">
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

            <div class="px-4 py-8 relative">
                <div class="flex justify-center mb-4">
                    <div class="bg-white rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div class="text-center">
                    <h1 class="text-2xl font-bold tracking-tight mb-2 drop-shadow-sm">
                        Aktivasi Berhasil!
                    </h1>

                    <div class="h-1 w-16 bg-green-400 mb-3 rounded-full mx-auto"></div>

                    <p class="text-green-100 text-sm mb-4">
                        Lisensi untuk {{ $license->digitalProduct->name }} telah berhasil diaktifkan.
                    </p>

                    <div class="flex justify-center mt-4">
                        <a href="{{ route('licenses.show', $license) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-green-700 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
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

            <!-- Simple divider instead of wave -->
            <div class="h-4 bg-gray-50 rounded-t-3xl"></div>
        </div>

        <div class="px-4 mt-4">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
                <div class="px-4 py-3 border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12">
                            <img class="h-12 w-12 rounded-lg object-cover"
                                src="{{ $license->digitalProduct->thumbnail_url }}"
                                alt="{{ $license->digitalProduct->name }}"
                                onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}';">
                        </div>
                        <div class="ml-3">
                            <h2 class="text-base font-medium text-gray-900">
                                {{ $license->digitalProduct->name }}
                            </h2>
                            <div class="mt-1 flex flex-wrap text-xs text-gray-500">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mr-2">
                                    Lisensi Aktif
                                </span>
                                <span
                                    class="text-xs text-gray-500">{{ substr($license->license_key, 0, 6) }}...{{ substr($license->license_key, -6) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-4 py-4">
                    <div class="mb-4">
                        <h3 class="text-base font-medium text-gray-900 mb-3">Detail Aktivasi</h3>

                        <div class="rounded-md bg-green-50 p-3 mb-4">
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
                                    <h3 class="text-xs font-medium text-green-800">Aktivasi Berhasil</h3>
                                    <div class="mt-1 text-xs text-green-700">
                                        <p>Perangkat: <span class="font-medium">{{ $activation->device_name }}</span></p>
                                        <p class="mt-1">{{ $activation->created_at->format('d F Y, H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($activation->notes)
                            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                <h4 class="text-xs font-medium text-gray-500 mb-1">Catatan</h4>
                                <div class="text-xs text-gray-900">
                                    {{ $activation->notes }}
                                </div>
                            </div>
                        @endif

                        <div class="mt-4">
                            <h4 class="text-xs font-medium text-gray-700 mb-2">Informasi Lisensi</h4>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <h5 class="text-xs font-medium text-gray-500 mb-1">Aktivasi</h5>
                                    <div class="text-xs text-gray-900">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{ $license->activation_count }}</span>
                                            <span class="mx-1">/</span>
                                            <span>{{ $license->max_activations ?: '∞' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-3">
                                    <h5 class="text-xs font-medium text-gray-500 mb-1">Masa Berlaku</h5>
                                    <div class="text-xs text-gray-900">
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

                <div class="px-4 py-3 bg-gray-50 border-t border-gray-100">
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('licenses.index') }}"
                            class="inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            Daftar Lisensi
                        </a>

                        <a href="{{ route('licenses.show', $license) }}"
                            class="inline-flex justify-center items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Detail Lisensi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
