<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Premium Everyday'))</title>
    <meta name="description"
        content="Premium Everyday - Your trusted partner for high-quality products and exceptional service.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="font-sans antialiased" x-data="{ mobileMenuOpen: false }">
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        @include('pages.desktop.layouts.navbar')

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        @include('pages.desktop.layouts.footer')
    </div>

    @livewireScripts
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Flash Messages -->
    @if (session('swal'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const swalData = @json(session('swal'));

                // Parse the didOpen function if it exists
                if (swalData.didOpen) {
                    const didOpenFunc = new Function('toast', swalData.didOpen);
                    swalData.didOpen = didOpenFunc;
                }

                // Handle different button actions
                Swal.fire(swalData).then((result) => {
                        if (result.isConfirmed) {
                            if (swalData.confirmButtonText === 'Mulai Belanja') {
                                window.location.href = "{{ route('products.index') }}";
                            } else if (swalData.confirmButtonText === 'Saya Mengerti') {
                                // Stay on the current page or redirect to profile
                                @auth
                                window.location.href = "{{ route('user.profile') }}";
                            @endauth
                        }
                    } else if (result.dismiss === Swal.DismissReason.cancel && swalData.cancelButtonText ===
                        'Kirim Ulang Email') {
                        // Send a request to resend verification email
                        fetch("{{ route('verification.resend') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                body: '_token=' + document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            })
                            .then(response => {
                                if (response.ok) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Email Terkirim!',
                                        text: 'Link verifikasi baru telah dikirim ke email Anda.',
                                        timer: 3000,
                                        timerProgressBar: true
                                    });
                                } else {
                                    throw new Error('Gagal mengirim email');
                                }
                            })
                            .catch(error => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: 'Gagal mengirim ulang email verifikasi. Silakan coba lagi nanti.',
                                    timer: 3000,
                                    timerProgressBar: true
                                });
                            });
                    }
                });
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    position: 'top-end',
                    toast: true
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    position: 'top-end',
                    toast: true
                });
            });
        </script>
    @endif

    <!-- Additional Scripts -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</body>

</html>
