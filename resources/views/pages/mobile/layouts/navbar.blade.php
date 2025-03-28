@props(['user' => null, 'notifications' => [], 'unreadCount' => 0])

<nav class="bg-white shadow-sm" x-data="{ open: false }">
    <div class="px-4 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img class="h-12 w-auto" src="{{ asset('images/logo.webp') }}" alt="Premium Everyday">
                </a>
            </div>

            <!-- Right Side Menu (Cart and Toggle) -->
            <div class="flex items-center space-x-2">
                <!-- Cart -->
                <div class="flex items-center">
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-500">
                        <span class="sr-only">View cart</span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        @if (Session::has('cart') && count(Session::get('cart')) > 0)
                            <span id="cart-count-mobile"
                                class="absolute top-1.5 right-1.5 block h-5 w-5 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center">
                                {{ count(Session::get('cart')) }}
                            </span>
                        @endif
                    </a>
                </div>

                <!-- Menu Button -->
                <button @click="open = !open"
                    class="text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600">
                    <span class="sr-only">Open menu</span>
                    <svg class="h-6 w-6" x-show="!open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16">
                        </path>
                    </svg>
                    <svg class="h-6 w-6" x-show="open" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="px-2 pt-2 pb-3 space-y-1" style="display: none;">
        <a href="{{ route('products.index') }}"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
            Products
        </a>
        <a href="{{ route('timeline') }}"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Timeline</a>
        <a href="{{ route('faq') }}"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">FAQ</a>
        <a href="{{ route('contact') }}"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Contact</a>

        @auth
            <!-- Notifications -->
            <x-notification-list-mobile :notifications="auth()->user()->notifications()->latest()->take(5)->get()" :unreadCount="auth()->user()->unreadNotifications->count()" />

            <!-- User Menu -->
            <div class="border-t border-gray-200 pt-4 pb-3">
                <div class="px-3">
                    <p class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</p>
                </div>
                <div class="mt-3 space-y-1">
                    @if (Auth::user()->role === 1)
                        <a href="{{ url('/admin') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Dashboard
                            Admin</a>
                    @endif
                    <a href="{{ route('user.profile') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Profile</a>
                    <a href="{{ route('user.payments.history') }}"
                        class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('user.payments.*') ? 'text-primary bg-primary-50' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="mr-4 flex-shrink-0 h-6 w-6 {{ request()->routeIs('user.payments.*') ? 'text-primary' : 'text-gray-400 group-hover:text-gray-500' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Riwayat Pembayaran
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="mt-6 px-3 space-y-2">
                <a href="{{ route('login') }}"
                    class="block w-full px-4 py-2 text-center font-medium text-primary bg-white border border-primary rounded-md hover:bg-primary hover:text-white transition">
                    Login
                </a>
                <a href="{{ route('register') }}"
                    class="block w-full px-4 py-2 text-center font-medium text-white bg-primary rounded-md hover:bg-primary-dark transition">
                    Register
                </a>
            </div>
        @endauth
    </div>
</nav>
