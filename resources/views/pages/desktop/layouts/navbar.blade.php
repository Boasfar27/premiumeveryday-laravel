@props(['user' => null, 'notifications' => [], 'unreadCount' => 0])

<nav class="bg-white shadow-sm fixed top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo & Primary Nav -->
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img class="h-12 w-auto" src="{{ asset('images/logo.webp') }}" alt="Premium Everyday">
                    </a>
                </div>

                <!-- Primary Nav -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('home') ? 'border-primary text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                        Home
                    </a>
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('products.*') ? 'border-primary text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                        Products
                    </a>
                    <a href="{{ route('timeline') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('timeline') ? 'border-primary text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                        Timeline
                    </a>
                    <a href="{{ route('faq') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('faq') ? 'border-primary text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                        FAQ
                    </a>
                    <a href="{{ route('contact') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('contact') ? 'border-primary text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                        Contact
                    </a>
                </div>
            </div>

            <!-- Right Navigation -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-500 hover:text-gray-700">
                    <span class="sr-only">View cart</span>
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    @if (Session::has('cart') && count(Session::get('cart')) > 0)
                        <span id="cart-count"
                            class="absolute top-1.5 right-1.5 block h-5 w-5 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center">
                            {{ count(Session::get('cart')) }}
                        </span>
                    @endif
                </a>

                @auth
                    <!-- Notifications -->
                    <x-notification-dropdown :notifications="auth()->user()->notifications()->latest()->take(5)->get()" :unreadCount="auth()->user()->unreadNotifications->count()" />

                    <!-- Profile Dropdown -->
                    <div class="ml-3 relative" x-data="{ open: false }" @click.away="open = false">
                        <div>
                            <button @click="open = !open" type="button"
                                class="flex items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 space-x-2"
                                id="user-menu-button">
                                <span class="sr-only">Open user menu</span>
                                @if (auth()->user()->avatar)
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ asset(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}">
                                @endif
                                <span class="text-gray-700 font-medium">{{ auth()->user()->name }}</span>
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            role="menu">
                            @if (auth()->user()->role === 1)
                                <a href="{{ route('admin.dashboard') }}"
                                    class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                    Dashboard Admin
                                </a>
                            @endif
                            <a href="{{ route('user.profile') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Profile</a>
                            <a href="{{ route('user.payments.history') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Payment
                                History</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100"
                                    role="menuitem">Sign out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}"
                            class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}"
                            class="bg-primary text-white hover:bg-primary-dark px-4 py-2 rounded-md text-sm font-medium transition">Register</a>
                    </div>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100"
                    aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen" class="sm:hidden" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}"
                class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('home') ? 'border-primary text-primary bg-primary-50' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }} text-base font-medium">
                Home
            </a>
            <a href="{{ route('products.index') }}"
                class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('products.*') ? 'border-primary text-primary bg-primary-50' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }} text-base font-medium">
                Products
            </a>
            <a href="{{ route('timeline') }}"
                class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('timeline') ? 'border-primary text-primary bg-primary-50' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }} text-base font-medium">
                Timeline
            </a>
            <a href="{{ route('faq') }}"
                class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('faq') ? 'border-primary text-primary bg-primary-50' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }} text-base font-medium">
                FAQ
            </a>
            <a href="{{ route('contact') }}"
                class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('contact') ? 'border-primary text-primary bg-primary-50' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }} text-base font-medium">
                Contact
            </a>
        </div>

        @auth
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="flex items-center px-4">
                    @if (auth()->user()->avatar)
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset(auth()->user()->avatar) }}"
                            alt="{{ auth()->user()->name }}">
                    @else
                        <div
                            class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ auth()->user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    @if (auth()->user()->role === 1)
                        <a href="{{ route('admin.dashboard') }}"
                            class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                            Dashboard Admin
                        </a>
                    @endif
                    <a href="{{ route('user.profile') }}"
                        class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        Profile
                    </a>
                    <a href="{{ route('user.payments.history') }}"
                        class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        Payment History
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full px-4 py-2 text-left text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="space-y-1">
                    <a href="{{ route('login') }}"
                        class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        Register
                    </a>
                </div>
            </div>
        @endauth
    </div>
</nav>
