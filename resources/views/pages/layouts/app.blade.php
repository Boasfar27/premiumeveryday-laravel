<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Premium Everyday')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#B03052',
                        'primary-dark': '#3D0301',
                        secondary: '#D76C82',
                        'secondary-light': '#E98E9F'
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    @yield('styles')

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .navbar-fixed {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 50;
            transition: all 0.3s ease-in-out;
        }

        .navbar-fixed.scrolled {
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .auth-page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .auth-page .navbar {
            @apply hidden;
        }

        .auth-page .footer {
            @apply hidden;
        }

        .section-nav {
            @apply fixed right-4 top-1/2 transform -translate-y-1/2 z-50 hidden lg:block;
        }

        .section-nav a {
            @apply block w-3 h-3 mb-4 rounded-full border-2 border-primary transition-all duration-300;
        }

        .section-nav a.active {
            @apply bg-primary;
        }

        .section-nav a:hover {
            @apply bg-primary-dark border-primary-dark;
        }

        /* Sweet Alert Custom Styles */
        .swal2-popup {
            border-radius: 1rem;
        }

        .swal2-icon {
            border-color: var(--primary) !important;
            color: var(--primary) !important;
        }

        .swal2-confirm {
            background: linear-gradient(to right, var(--primary), var(--primary-dark)) !important;
            border-radius: 0.5rem !important;
        }

        :root {
            --primary: #B03052;
            --primary-dark: #3D0301;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100" x-data="{ mobileMenu: false }">
    @if (
        !request()->is('login') &&
            !request()->is('register') &&
            !request()->is('password/reset') &&
            !request()->is('password/reset/*'))
        @include('components.navbar.main')

        <!-- Section Navigation Dots -->
        <nav class="section-nav">
            <a href="#products" class="nav-dot" data-section="products" title="Produk"></a>
            <a href="#timeline" class="nav-dot" data-section="timeline" title="Timeline"></a>
            <a href="#faq" class="nav-dot" data-section="faq" title="FAQ"></a>
            <a href="#feedback" class="nav-dot" data-section="feedback" title="Testimoni"></a>
            <a href="#contact" class="nav-dot" data-section="contact" title="Kontak"></a>
        </nav>
    @endif

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    @if (
        !request()->is('login') &&
            !request()->is('register') &&
            !request()->is('password/reset') &&
            !request()->is('password/reset/*'))
        @include('components.footer.main')
    @endif

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Navbar scroll effect
        const navbar = document.querySelector('nav');
        if (navbar) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 0) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        }

        // Section navigation dots
        document.addEventListener('DOMContentLoaded', () => {
            const sections = document.querySelectorAll('section[id]');
            const navDots = document.querySelectorAll('.nav-dot');

            function updateNavDots() {
                const scrollPosition = window.scrollY + window.innerHeight / 2;

                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.offsetHeight;
                    const sectionId = section.getAttribute('id');

                    if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                        navDots.forEach(dot => {
                            dot.classList.remove('active');
                            if (dot.getAttribute('href') === `#${sectionId}`) {
                                dot.classList.add('active');
                            }
                        });
                    }
                });
            }

            window.addEventListener('scroll', updateNavDots);
            updateNavDots();
        });
    </script>

    <!-- Sweet Alert -->
    @if (session()->has('swal'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const swalData = @json(session('swal'));
                Swal.fire({
                    ...swalData,
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('products') }}";
                    }
                });
            });
        </script>
    @endif

    @stack('scripts')
</body>

</html>
