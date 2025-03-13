<div class="ml-3 relative">
    <div>
        <button @click="userDropdownOpen = !userDropdownOpen"
            class="flex items-center text-sm font-medium text-pink-600 hover:text-pink-800 focus:outline-none transition duration-150 ease-in-out">
            <div class="flex items-center">
                <div class="h-8 w-8 rounded-full bg-pink-200 flex items-center justify-center text-pink-600">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <span class="ml-2">{{ auth()->user()->name }}</span>
                <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </div>
        </button>
    </div>
    <div x-show="userDropdownOpen" @click.away="userDropdownOpen = false"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95"
        class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100">
        <div class="py-1">
            @if (auth()->user()->role == 1)
                <a href="{{ route('admin.dashboard') }}"
                    class="group flex items-center px-4 py-2 text-sm text-pink-700 hover:bg-pink-100">
                    <svg class="mr-3 h-5 w-5 text-pink-400 group-hover:text-pink-500" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M2 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4zM8 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H9a1 1 0 01-1-1V4zM15 3a1 1 0 00-1 1v12a1 1 0 001 1h2a1 1 0 001-1V4a1 1 0 00-1-1h-2z" />
                    </svg>
                    Dashboard Admin
                </a>
            @endif
            <a href="{{ route('user.profile') }}"
                class="group flex items-center px-4 py-2 text-sm text-pink-700 hover:bg-pink-100">
                <svg class="mr-3 h-5 w-5 text-pink-400 group-hover:text-pink-500" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                        clip-rule="evenodd" />
                </svg>
                Profil
            </a>
            <a href="{{ route('user.orders') }}"
                class="group flex items-center px-4 py-2 text-sm text-pink-700 hover:bg-pink-100">
                <svg class="mr-3 h-5 w-5 text-pink-400 group-hover:text-pink-500" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                </svg>
                Pesanan Saya
            </a>
        </div>
        <div class="py-1">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="group flex w-full items-center px-4 py-2 text-sm text-pink-700 hover:bg-pink-100">
                    <svg class="mr-3 h-5 w-5 text-pink-400 group-hover:text-pink-500" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                            clip-rule="evenodd" />
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </div>
</div>
