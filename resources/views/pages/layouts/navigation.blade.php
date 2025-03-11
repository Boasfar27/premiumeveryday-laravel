<!-- Navigation -->
<nav class="bg-primary">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-white font-bold text-xl">
                        Premium Everyday
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ route('products') }}" 
                       class="{{ request()->routeIs('products') ? 'border-secondary text-white' : 'border-transparent text-gray-300 hover:border-gray-300 hover:text-white' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Produk
                    </a>
                    <a href="{{ route('timeline') }}"
                       class="{{ request()->routeIs('timeline') ? 'border-secondary text-white' : 'border-transparent text-gray-300 hover:border-gray-300 hover:text-white' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Timeline
                    </a>
                    <a href="{{ route('contact') }}"
                       class="{{ request()->routeIs('contact') ? 'border-secondary text-white' : 'border-transparent text-gray-300 hover:border-gray-300 hover:text-white' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Kontak
                    </a>
                </div>
            </div>

            <!-- User Menu -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                @auth
                    <div class="ml-3 relative" x-data="{ open: false }" @click.away="open = false">
                        <div>
                            <button @click="open = !open" class="flex text-sm text-white focus:outline-none">
                                <span class="sr-only">Open user menu</span>
                                {{ auth()->user()->name }}
                                <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5">
                            @if(auth()->user()->role === 1)
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Dashboard Admin
                                </a>
                            @else
                                <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Dashboard
                                </a>
                                <a href="{{ route('user.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Pesanan Saya
                                </a>
                                <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Profil
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="ml-4 text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                        Daftar
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-primary-dark focus:outline-none">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('products') }}" class="{{ request()->routeIs('products') ? 'bg-primary-dark text-white' : 'text-gray-300 hover:bg-primary-dark hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">
                Produk
            </a>
            <a href="{{ route('timeline') }}" class="{{ request()->routeIs('timeline') ? 'bg-primary-dark text-white' : 'text-gray-300 hover:bg-primary-dark hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">
                Timeline
            </a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'bg-primary-dark text-white' : 'text-gray-300 hover:bg-primary-dark hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">
                Kontak
            </a>
        </div>

        @auth
            <div class="pt-4 pb-3 border-t border-primary-dark">
                <div class="flex items-center px-5">
                    <div class="ml-3">
                        <div class="text-base font-medium text-white">{{ auth()->user()->name }}</div>
                        <div class="text-sm font-medium text-gray-400">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    @if(auth()->user()->role === 1)
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-primary-dark">
                            Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-primary-dark">
                            Dashboard
                        </a>
                        <a href="{{ route('user.orders') }}" class="block px-4 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-primary-dark">
                            Pesanan Saya
                        </a>
                        <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-primary-dark">
                            Profil
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-red-400 hover:text-red-300 hover:bg-primary-dark">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-3 border-t border-primary-dark">
                <div class="space-y-1">
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-primary-dark">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-primary-dark">
                        Daftar
                    </a>
                </div>
            </div>
        @endauth
    </div>
</nav> 