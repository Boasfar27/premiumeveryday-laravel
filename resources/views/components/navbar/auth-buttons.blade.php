<div class="hidden sm:flex sm:items-center sm:ml-6">
    @auth
        <x-navbar.user-dropdown>
            <x-slot name="trigger">
                <button type="button" class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    <span class="sr-only">Open user menu</span>
                    <img class="h-8 w-8 rounded-full" src="{{ auth()->user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&color=7F9CF5&background=EBF4FF' }}" alt="{{ auth()->user()->name }}">
                </button>
            </x-slot>
        </x-navbar.user-dropdown>
    @else
        <a href="{{ route('login') }}" class="text-white hover:text-gray-200">
            Masuk
        </a>
        <a href="{{ route('register') }}" class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
            Daftar
        </a>
    @endauth
</div> 