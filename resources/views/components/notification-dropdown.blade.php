@props(['notifications' => [], 'unreadCount' => 0])

<div class="ml-3 relative" x-data="{ open: false }" @click.away="open = false">
    <button @click="open = !open" class="relative p-2 text-gray-500 hover:text-gray-700 focus:outline-none"
        aria-expanded="false" aria-haspopup="true">
        <span class="sr-only">View notifications</span>
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if ($unreadCount > 0)
            <span class="absolute top-1.5 right-1.5 flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
            </span>
        @endif
    </button>

    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
        role="menu" aria-orientation="vertical" aria-labelledby="notification-menu-button" tabindex="-1"
        style="display: none;">
        <div class="py-1 max-h-96 overflow-y-auto" role="none">
            <div class="flex items-center justify-between px-4 py-2 border-b border-gray-100">
                <h3 class="text-sm font-medium text-gray-900">Notifikasi</h3>
                @if ($unreadCount > 0)
                    <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs text-primary hover:text-primary-dark">
                            Tandai semua dibaca
                        </button>
                    </form>
                @endif
            </div>

            @forelse ($notifications as $notification)
                <div
                    class="px-4 py-3 border-b border-gray-50 hover:bg-gray-50 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }}">
                    <a href="{{ route('notifications.read', $notification->id) }}" class="block">
                        <p class="text-sm font-medium text-gray-900">
                            {{ $notification->data['message'] ?? 'Notification' }}
                        </p>
                        <div class="flex items-center mt-1">
                            @if (isset($notification->data['link']))
                                <a href="{{ $notification->data['link'] }}"
                                    class="text-xs text-primary hover:text-primary-dark font-medium mr-3">
                                    Lihat detail
                                </a>
                            @endif
                            <span class="text-xs text-gray-500">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </a>
                </div>
            @empty
                <div class="px-4 py-6 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">
                        Belum ada notifikasi
                    </p>
                </div>
            @endforelse

            <div class="py-1">
                <a href="{{ route('notifications.index') }}"
                    class="block px-4 py-2 text-sm text-center text-primary hover:text-primary-dark font-medium">
                    Lihat semua notifikasi
                </a>
            </div>
        </div>
    </div>
</div>
