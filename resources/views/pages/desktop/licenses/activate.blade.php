@extends('pages.desktop.layouts.app')

@section('title', 'Aktivasi Lisensi')

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
                    AKTIVASI LISENSI
                </span>

                <div class="md:w-2/3 xl:w-1/2">
                    <h1 class="text-3xl sm:text-4xl font-bold tracking-tight mb-3 drop-shadow-sm">
                        Aktivasi Lisensi Produk
                    </h1>

                    <div class="h-1 w-24 bg-blue-400 mb-4 rounded-full"></div>

                    <p class="text-blue-100 text-lg mb-4 max-w-xl">
                        Aktifkan lisensi {{ $license->digitalProduct->name }} untuk digunakan pada perangkat atau domain
                        ini.
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
                            Kembali ke Detail Lisensi
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
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if ($license->isActive()) bg-green-100 text-green-800 
                                @elseif($license->isExpired()) bg-red-100 text-red-800 
                                @else bg-blue-100 text-blue-800 @endif">
                                    {{ $license->isActive() ? 'Aktif' : ($license->isExpired() ? 'Kadaluarsa' : ucfirst($license->status)) }}
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
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Informasi Aktivasi</h3>

                        @if ($license->isExpired())
                            <div class="rounded-md bg-red-50 p-4 mb-4">
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
                                        <h3 class="text-sm font-medium text-red-800">Lisensi Telah Kadaluarsa</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <p>Lisensi ini telah kadaluarsa pada
                                                {{ $license->expires_at->format('d M Y') }}. Anda tidak dapat mengaktifkan
                                                lisensi yang sudah kadaluarsa.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($license->hasReachedMaxActivations())
                            <div class="rounded-md bg-yellow-50 p-4 mb-4">
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
                                        <h3 class="text-sm font-medium text-yellow-800">Batas Aktivasi Tercapai</h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <p>Lisensi ini telah mencapai batas maksimum aktivasi
                                                ({{ $license->max_activations }}). Hubungi dukungan pelanggan jika Anda
                                                memerlukan aktivasi tambahan.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="rounded-md bg-blue-50 p-4 mb-4">
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
                                        <h3 class="text-sm font-medium text-blue-800">Informasi Aktivasi</h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <p>Aktifkan lisensi ini untuk menggunakan produk digital pada perangkat atau
                                                domain ini. Aktivasi saat ini: <span
                                                    class="font-medium">{{ $license->activation_count }} dari
                                                    {{ $license->max_activations ?: '∞' }}</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (!$license->isExpired() && !$license->hasReachedMaxActivations())
                            <form action="{{ route('licenses.process-activation', $license) }}" method="POST"
                                class="space-y-4">
                                @csrf
                                <div>
                                    <label for="device_name" class="block text-sm font-medium text-gray-700">Nama Perangkat
                                        / Domain *</label>
                                    <div class="mt-1">
                                        <input type="text" name="device_name" id="device_name"
                                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            placeholder="contoh: Laptop Saya, website.com" required>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Nama yang akan digunakan untuk mengidentifikasi
                                        perangkat atau domain ini.</p>
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Catatan
                                        (opsional)</label>
                                    <div class="mt-1">
                                        <textarea id="notes" name="notes" rows="3"
                                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            placeholder="Tambahkan catatan atau informasi tambahan di sini..."></textarea>
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4 text-sm text-gray-600">
                                    <p class="font-medium text-gray-700 mb-2">Informasi Penting:</p>
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li>Setiap aktivasi dikaitkan dengan perangkat atau domain tertentu.</li>
                                        <li>Lisensi ini dapat diaktifkan {{ $license->max_activations ?: 'tanpa batas' }}
                                            kali.</li>
                                        <li>Aktivasi saat ini: {{ $license->activation_count }} dari
                                            {{ $license->max_activations ?: '∞' }}.</li>
                                        @if ($license->expires_at)
                                            <li>Lisensi ini berlaku hingga {{ $license->expires_at->format('d M Y') }}.
                                            </li>
                                        @else
                                            <li>Lisensi ini berlaku selamanya.</li>
                                        @endif
                                    </ul>
                                </div>

                                <div class="flex items-center">
                                    <input id="terms" name="terms" type="checkbox"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" required>
                                    <label for="terms" class="ml-2 block text-sm text-gray-900">
                                        Saya memahami bahwa aktivasi ini akan mengurangi jumlah aktivasi yang tersedia
                                    </label>
                                </div>

                                <div class="pt-4">
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
                            <div class="flex justify-center py-3">
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

                @if (!$license->isExpired() && !$license->hasReachedMaxActivations())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        <div class="text-sm text-gray-500">
                            <p class="font-medium text-gray-700 mb-1">Aktivasi Sebelumnya:</p>

                            @if ($license->activations->count() > 0)
                                <div class="overflow-hidden border border-gray-200 rounded-md">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Nama Perangkat</th>
                                                <th scope="col"
                                                    class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($license->activations as $activation)
                                                <tr>
                                                    <td class="px-3 py-2 whitespace-nowrap text-xs text-gray-900">
                                                        {{ $activation->device_name }}</td>
                                                    <td class="px-3 py-2 whitespace-nowrap text-xs text-gray-500">
                                                        {{ $activation->created_at->format('d M Y, H:i') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-sm text-gray-500">Belum ada aktivasi sebelumnya.</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
