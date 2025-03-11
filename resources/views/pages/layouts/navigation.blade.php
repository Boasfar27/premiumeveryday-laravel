<!-- Navigation -->
<nav class="bg-primary" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-white font-bold text-xl hover:text-secondary transition-colors duration-200">
                        Premium Everyday
                    </a>
                </div>

                <!-- Navigation Links - Desktop -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ route('products') }}" 
                       class="{{ request()->routeIs('products') ? 'border-secondary text-white' : 'border-transparent text-gray-300 hover:border-secondary hover:text-white' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all duration-200">
                        Produk
                    </a>
                    <a href="{{ route('timeline') }}"
                       class="{{ request()->routeIs('timeline') ? 'border-secondary text-white' : 'border-transparent text-gray-300 hover:border-secondary hover:text-white' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all duration-200">
                        Timeline
                    </a>
                    <a href="{{ route('contact') }}"
                       class="{{ request()->routeIs('contact') ? 'border-secondary text-white' : 'border-transparent text-gray-300 hover:border-secondary hover:text-white' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all duration-200">
                        Kontak
                    </a>
                </div>
            </div>

            <!-- User Menu - Desktop -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                @auth
                    <div class="ml-3 relative" x-data="{ open: false }" @click.away="open = false">
                        <div>
                            <button @click="open = !open" class="flex items-center text-sm text-white hover:text-secondary transition-colors duration-200 focus:outline-none">
                                <span class="mr-2">{{ auth()->user()->name }}</span>
                                <svg class="h-5 w-5 transition-transform duration-200" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100"
                             style="display: none;">
                            <div class="py-1">
                                @if(auth()->user()->role === 1)
                                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-secondary hover:text-white transition-colors duration-200">
                                        Dashboard Admin
                                    </a>
                                @else
                                    <a href="{{ route('user.dashboard') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-secondary hover:text-white transition-colors duration-200">
                                        Dashboard
                                    </a>
                                    <a href="{{ route('user.orders') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-secondary hover:text-white transition-colors duration-200">
                                        Pesanan Saya
                                    </a>
                                    <a href="{{ route('user.profile') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-secondary hover:text-white transition-colors duration-200">
                                        Profil
                                    </a>
                                @endif
                            </div>
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-50 transition-colors duration-200">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white hover:bg-primary-dark px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="bg-secondary hover:bg-secondary-light text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            Daftar
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-primary-dark focus:outline-none transition-colors duration-200">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" :class="{'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="sm:hidden bg-primary-dark"
         style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('products') }}" 
               class="{{ request()->routeIs('products') ? 'bg-secondary text-white' : 'text-gray-300 hover:bg-secondary-light hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">
                Produk
            </a>
            <a href="{{ route('timeline') }}" 
               class="{{ request()->routeIs('timeline') ? 'bg-secondary text-white' : 'text-gray-300 hover:bg-secondary-light hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">
                Timeline
            </a>
            <a href="{{ route('contact') }}" 
               class="{{ request()->routeIs('contact') ? 'bg-secondary text-white' : 'text-gray-300 hover:bg-secondary-light hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">
                Kontak
            </a>
        </div>

        @auth
            <div class="pt-4 pb-3 border-t border-primary">
                <div class="flex items-center px-5">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-secondary flex items-center justify-center">
                            <span class="text-white font-medium text-lg">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-white">{{ auth()->user()->name }}</div>
                        <div class="text-sm font-medium text-gray-400">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 px-2 space-y-1">
                    @if(auth()->user()->role === 1)
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-secondary hover:text-white transition-colors duration-200">
                            Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-secondary hover:text-white transition-colors duration-200">
                            Dashboard
                        </a>
                        <a href="{{ route('user.orders') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-secondary hover:text-white transition-colors duration-200">
                            Pesanan Saya
                        </a>
                        <a href="{{ route('user.profile') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-secondary hover:text-white transition-colors duration-200">
                            Profil
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-400 hover:bg-red-500 hover:text-white transition-colors duration-200">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-3 border-t border-primary px-5 space-y-2">
                <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-secondary hover:text-white transition-colors duration-200">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 rounded-md text-base font-medium bg-secondary hover:bg-secondary-light text-white transition-colors duration-200">
                    Daftar
                </a>
            </div>
        @endauth
    </div>
</nav> 