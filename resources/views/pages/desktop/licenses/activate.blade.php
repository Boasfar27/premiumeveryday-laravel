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

                <!-- Progress Steps -->
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <div class="flex justify-between items-center">
                        <div class="w-full">
                            <ol class="flex items-center w-full text-sm font-medium text-center text-gray-500">
                                <li
                                    class="flex md:w-full items-center text-blue-600 after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-200 after:border-1 after:hidden sm:after:inline-block after:mx-4 xl:after:mx-8 relative">
                                    <span
                                        class="flex items-center justify-center w-8 h-8 bg-blue-200 rounded-full shrink-0">
                                        <svg class="w-3.5 h-3.5 text-blue-600" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                        </svg>
                                    </span>
                                    <span class="hidden sm:inline-flex items-center ml-2">Verifikasi Lisensi</span>
                                </li>
                                <li
                                    class="flex md:w-full items-center text-blue-600 after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-4 xl:after:mx-8 relative">
                                    <span
                                        class="flex items-center justify-center w-8 h-8 bg-blue-200 rounded-full shrink-0">
                                        <svg class="w-3.5 h-3.5 text-blue-600" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </span>
                                    <span class="hidden sm:inline-flex items-center ml-2">Input Informasi</span>
                                </li>
                                <li class="flex items-center">
                                    <span
                                        class="flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full shrink-0">
                                        <svg class="w-3.5 h-3.5 text-gray-500" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                            <path
                                                d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z" />
                                        </svg>
                                    </span>
                                    <span class="hidden sm:inline-flex items-center ml-2">Selesai</span>
                                </li>
                            </ol>
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
                                    <label for="device_name" class="block text-sm font-medium text-gray-700">Nama
                                        Perangkat
                                        / Domain *</label>
                                    <div class="mt-1 relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <input type="text" name="device_name" id="device_name"
                                            class="pl-10 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            placeholder="contoh: Laptop Saya, website.com" required
                                            value="{{ old('device_name', request()->has('device_name') ? request('device_name') : '') }}">
                                        <!-- Auto-detected device name suggestion -->
                                        <div class="mt-1 text-xs text-gray-500">
                                            <button type="button" id="use-detected-device"
                                                class="text-blue-600 hover:text-blue-800 focus:outline-none">
                                                Gunakan nama perangkat terdeteksi: <span
                                                    id="detected-device-name">...</span>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Nama yang akan digunakan untuk mengidentifikasi
                                        perangkat atau domain ini.</p>
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Catatan
                                        (opsional)</label>
                                    <div class="mt-1 relative">
                                        <div class="absolute top-3 left-3 pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </div>
                                        <textarea id="notes" name="notes" rows="3"
                                            class="pl-10 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            placeholder="Tambahkan catatan atau informasi tambahan di sini...">{{ old('notes') }}</textarea>
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
                                    <button type="submit" id="activate-button"
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Detect device name
            let deviceName = '';

            // Try to get browser and OS information
            const userAgent = navigator.userAgent;
            const platform = navigator.platform;

            // Get browser name
            let browser = '';
            if (userAgent.indexOf("Chrome") > -1) browser = "Chrome";
            else if (userAgent.indexOf("Safari") > -1) browser = "Safari";
            else if (userAgent.indexOf("Firefox") > -1) browser = "Firefox";
            else if (userAgent.indexOf("MSIE") > -1 || userAgent.indexOf("Trident") > -1) browser =
                "Internet Explorer";
            else if (userAgent.indexOf("Edge") > -1) browser = "Edge";
            else browser = "Unknown Browser";

            // Get OS name
            let os = '';
            if (platform.indexOf("Win") > -1) os = "Windows";
            else if (platform.indexOf("Mac") > -1) os = "MacOS";
            else if (platform.indexOf("Linux") > -1) os = "Linux";
            else if (platform.indexOf("Android") > -1) os = "Android";
            else if (platform.indexOf("iPhone") > -1 || platform.indexOf("iPad") > -1 || platform.indexOf("iPod") >
                -1) os = "iOS";
            else os = "Unknown OS";

            // Get hostname if available
            let hostname = window.location.hostname;

            // Try to get device model information
            let deviceInfo = '';
            if (navigator.userAgentData && navigator.userAgentData.getHighEntropyValues) {
                navigator.userAgentData.getHighEntropyValues(["model", "platformVersion"])
                    .then(function(data) {
                        if (data.model) deviceInfo = data.model;
                        updateDeviceNameUI();
                    })
                    .catch(function() {
                        updateDeviceNameUI();
                    });
            } else {
                updateDeviceNameUI();
            }

            function updateDeviceNameUI() {
                if (hostname && hostname !== 'localhost' && !hostname.includes('127.0.0.1')) {
                    deviceName = hostname;
                } else {
                    deviceName = os + ' ' + browser + (deviceInfo ? ' (' + deviceInfo + ')' : '');
                }

                const detectedDeviceNameEl = document.getElementById('detected-device-name');
                if (detectedDeviceNameEl) {
                    detectedDeviceNameEl.textContent = deviceName;
                }

                const useDetectedDeviceBtn = document.getElementById('use-detected-device');
                if (useDetectedDeviceBtn) {
                    useDetectedDeviceBtn.addEventListener('click', function() {
                        const deviceNameInput = document.getElementById('device_name');
                        if (deviceNameInput) {
                            deviceNameInput.value = deviceName;
                        }
                    });
                }
            }

            // Add loading state to the activate button
            const activateButton = document.getElementById('activate-button');
            const activationForm = activateButton ? activateButton.closest('form') : null;

            if (activateButton && activationForm) {
                activationForm.addEventListener('submit', function() {
                    activateButton.disabled = true;
                    activateButton.classList.add('opacity-75');
                    activateButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memproses...
                `;
                });
            }
        });
    </script>
@endsection
