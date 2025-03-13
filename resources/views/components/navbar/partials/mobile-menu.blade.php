<div x-show="mobileMenuOpen" class="sm:hidden" x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
    x-transition:leave-end="transform opacity-0 scale-95">
    <div class="pt-2 pb-3 space-y-1">
        @foreach ($navigation as $item)
            <a href="{{ route($item['route']) }}"
                class="{{ request()->routeIs($item['route']) ? 'bg-pink-50 border-pink-500 text-pink-700' : 'border-transparent text-pink-600 hover:bg-pink-50 hover:border-pink-300 hover:text-pink-800' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out">
                {{ $item['name'] }}
            </a>
        @endforeach
    </div>

    @auth
        <div class="pt-4 pb-3 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full bg-pink-200 flex items-center justify-center text-pink-600">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium text-pink-800">{{ auth()->user()->name }}</div>
                    <div class="text-sm font-medium text-pink-500">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                @if (auth()->user()->role == 1)
                    <a href="{{ route('admin.dashboard') }}"
                        class="block px-4 py-2 text-base font-medium text-pink-500 hover:text-pink-800 hover:bg-pink-100">Dashboard
                        Admin</a>
                @endif
                <a href="{{ route('user.profile') }}"
                    class="block px-4 py-2 text-base font-medium text-pink-500 hover:text-pink-800 hover:bg-pink-100">Profil</a>
                <a href="{{ route('user.orders') }}"
                    class="block px-4 py-2 text-base font-medium text-pink-500 hover:text-pink-800 hover:bg-pink-100">Pesanan
                    Saya</a>
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-base font-medium text-pink-500 hover:text-pink-800 hover:bg-pink-100">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="pt-4 pb-3 border-t border-gray-200">
            <div class="space-y-1">
                <a href="{{ route('login') }}"
                    class="block px-4 py-2 text-base font-medium text-pink-500 hover:text-pink-800 hover:bg-pink-100">Masuk</a>
                <a href="{{ route('register') }}"
                    class="block px-4 py-2 text-base font-medium text-pink-500 hover:text-pink-800 hover:bg-pink-100">Daftar</a>
            </div>
        </div>
    @endauth
</div>
