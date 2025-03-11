<div class="sm:hidden hidden" id="mobile-menu">
    <div class="px-2 pt-2 pb-3 space-y-1">
        <a href="{{ route('products') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('products*') ? 'bg-secondary text-white' : 'text-white hover:bg-secondary' }}">
            Produk
        </a>
        <a href="{{ route('timeline') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('timeline') ? 'bg-secondary text-white' : 'text-white hover:bg-secondary' }}">
            Timeline
        </a>
        <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('contact') ? 'bg-secondary text-white' : 'text-white hover:bg-secondary' }}">
            Kontak
        </a>
        @guest
            <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-secondary">
                Masuk
            </a>
            <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-secondary">
                Daftar
            </a>
        @endguest
    </div>
</div> 