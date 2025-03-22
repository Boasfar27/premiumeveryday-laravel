@extends('pages.mobile.layouts.app')

@section('title', 'Aktivasi Lisensi')

@section('content')
    <div class="bg-gray-50 min-h-screen pb-12">
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

            <div class="px-4 py-8 mt-4 relative">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-800 bg-opacity-50 text-blue-100 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                            clip-rule="evenodd" />
                    </svg>
                    AKTIVASI LISENSI
                </span>

                <h1 class="text-2xl font-bold tracking-tight mb-2 drop-shadow-sm">
                    Aktivasi Lisensi Produk
                </h1>

                <div class="h-1 w-16 bg-blue-400 mb-3 rounded-full"></div>

                <p class="text-blue-100 text-sm mb-4">
                    Aktifkan lisensi {{ $license->digitalProduct->name }} untuk digunakan pada perangkat atau domain ini.
                </p>

                <div class="flex items-center">
                    <a href="{{ route('licenses.show', $license) }}"
                        class="inline-flex items-center text-sm text-blue-100 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Kembali ke Detail
                    </a>
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
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                @if ($license->isActive()) bg-green-100 text-green-800 
                                @elseif($license->isExpired()) bg-red-100 text-red-800 
                                @else bg-blue-100 text-blue-800 @endif mr-2 mb-1">
                                    {{ $license->isActive() ? 'Aktif' : ($license->isExpired() ? 'Kadaluarsa' : ucfirst($license->status)) }}
                                </span>
                                <span
                                    class="text-xs text-gray-500">{{ substr($license->license_key, 0, 6) }}...{{ substr($license->license_key, -6) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-4 py-4">
                    <div class="mb-4">
                        <h3 class="text-base font-medium text-gray-900 mb-3">Informasi Aktivasi</h3>

                        @if ($license->isExpired())
                            <div class="rounded-md bg-red-50 p-3 mb-3">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-xs font-medium text-red-800">Lisensi Telah Kadaluarsa</h3>
                                        <div class="mt-1 text-xs text-red-700">
                                            <p>Lisensi ini telah kadaluarsa pada
                                                {{ $license->expires_at->format('d M Y') }}. Anda tidak dapat mengaktifkan
                                                lisensi yang sudah kadaluarsa.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($license->hasReachedMaxActivations())
                            <div class="rounded-md bg-yellow-50 p-3 mb-3">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-xs font-medium text-yellow-800">Batas Aktivasi Tercapai</h3>
                                        <div class="mt-1 text-xs text-yellow-700">
                                            <p>Lisensi ini telah mencapai batas maksimum aktivasi
                                                ({{ $license->max_activations }}). Hubungi dukungan pelanggan jika Anda
                                                memerlukan aktivasi tambahan.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="rounded-md bg-blue-50 p-3 mb-3">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-xs font-medium text-blue-800">Informasi Aktivasi</h3>
                                        <div class="mt-1 text-xs text-blue-700">
                                            <p>Aktivasi saat ini: <span
                                                    class="font-medium">{{ $license->activation_count }} dari
                                                    {{ $license->max_activations ?: '∞' }}</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (!$license->isExpired() && !$license->hasReachedMaxActivations())
                            <form action="{{ route('licenses.process-activation', $license) }}" method="POST"
                                class="space-y-3 mt-4">
                                @csrf
                                <div>
                                    <label for="device_name" class="block text-xs font-medium text-gray-700">Nama Perangkat
                                        / Domain *</label>
                                    <div class="mt-1">
                                        <input type="text" name="device_name" id="device_name"
                                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full text-sm border-gray-300 rounded-md"
                                            placeholder="contoh: Laptop Saya, website.com" required>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Nama untuk identifikasi perangkat atau domain
                                        ini.</p>
                                </div>

                                <div>
                                    <label for="notes" class="block text-xs font-medium text-gray-700">Catatan
                                        (opsional)</label>
                                    <div class="mt-1">
                                        <textarea id="notes" name="notes" rows="2"
                                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full text-sm border-gray-300 rounded-md"
                                            placeholder="Tambahkan catatan atau informasi tambahan..."></textarea>
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-3 text-xs text-gray-600">
                                    <p class="font-medium text-gray-700 mb-1">Informasi Penting:</p>
                                    <ul class="list-disc pl-4 space-y-1">
                                        <li>Setiap aktivasi dikaitkan dengan perangkat atau domain tertentu.</li>
                                        <li>Aktivasi saat ini: {{ $license->activation_count }} dari
                                            {{ $license->max_activations ?: '∞' }}.</li>
                                        @if ($license->expires_at)
                                            <li>Berlaku hingga {{ $license->expires_at->format('d M Y') }}.</li>
                                        @else
                                            <li>Berlaku selamanya.</li>
                                        @endif
                                    </ul>
                                </div>

                                <div class="flex items-center">
                                    <input id="terms" name="terms" type="checkbox"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" required>
                                    <label for="terms" class="ml-2 block text-xs text-gray-900">
                                        Saya memahami bahwa aktivasi ini akan menggunakan satu slot aktivasi
                                    </label>
                                </div>

                                <div class="pt-3">
                                    <button type="submit"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Aktivasi Sekarang
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="flex justify-center py-3 mt-2">
                                <a href="{{ route('licenses.show', $license) }}"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Kembali ke Detail Lisensi
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                @if (!$license->isExpired() && !$license->hasReachedMaxActivations() && $license->activations->count() > 0)
                    <div class="px-4 py-3 bg-gray-50 border-t border-gray-100">
                        <div class="text-xs text-gray-500">
                            <p class="font-medium text-gray-700 mb-1">Aktivasi Sebelumnya:</p>

                            <div class="overflow-hidden border border-gray-200 rounded-md">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Perangkat</th>
                                            <th scope="col"
                                                class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($license->activations->take(3) as $activation)
                                            <tr>
                                                <td class="px-3 py-2 whitespace-nowrap text-xs text-gray-900">
                                                    {{ $activation->device_name }}</td>
                                                <td class="px-3 py-2 whitespace-nowrap text-xs text-gray-500">
                                                    {{ $activation->created_at->format('d M Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if ($license->activations->count() > 3)
                                <div class="mt-2 text-center">
                                    <a href="{{ route('licenses.show', $license) }}"
                                        class="text-xs text-blue-600 hover:text-blue-800">
                                        Lihat semua aktivasi
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
