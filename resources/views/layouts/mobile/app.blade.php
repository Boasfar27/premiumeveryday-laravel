<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Everyday - @yield('title')</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    
    @stack('styles')
</head>
<body class="font-sans antialiased">
    <!-- Mobile Navigation -->
    <div class="md:hidden" x-data="{ open: false }">
        <!-- Top Bar -->
        <div class="bg-white shadow-lg">
            <div class="px-4 py-3 flex justify-between items-center">
                <a href="{{ url('/') }}" class="text-xl font-bold text-gray-800">
                    Premium Everyday
                </a>
                <button @click="open = !open" class="text-gray-500 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="open" class="bg-white shadow-lg">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('products') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Produk</a>
                <a href="{{ route('timeline') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Timeline</a>
                <a href="{{ route('faq') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">FAQ</a>
                <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Kontak</a>
                @guest
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Masuk</a>
                    <a href="{{ route('register') }}" class="block w-full text-center px-3 py-2 rounded-md text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">Daftar</a>
                @else
                    <div class="border-t border-gray-200 pt-4">
                        <div class="px-3 py-2">
                            <p class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                        <a href="{{ route('user.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Dashboard</a>
                        <a href="{{ route('user.orders') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Pesanan Saya</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Keluar</button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Mobile Footer -->
    <footer class="bg-gray-800 text-white md:hidden">
        <div class="px-4 py-8">
            <div class="space-y-8">
                <div>
                    <h3 class="text-lg font-semibold mb-2">Premium Everyday</h3>
                    <p class="text-gray-400">Solusi digital terbaik untuk kebutuhan Anda</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-2">Kontak</h3>
                    <p class="text-gray-400">Email: info@premiumeveryday.my.id</p>
                    <p class="text-gray-400">WhatsApp: +62 812-3456-7890</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-2">Ikuti Kami</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-700 pt-8">
                <p class="text-center text-gray-400">&copy; {{ date('Y') }} Premium Everyday. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html> 