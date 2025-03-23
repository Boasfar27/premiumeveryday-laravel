@props(['notifications' => [], 'unreadCount' => 0])

<div class="relative" x-data="{ showNotifications: false }">
    <button @click="showNotifications = !showNotifications"
        class="flex items-center justify-between w-full px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md">
        <div class="flex items-center">
            <svg class="h-5 w-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span>Notifikasi</span>
        </div>
        @if ($unreadCount > 0)
            <span
                class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <div x-show="showNotifications" @click.away="showNotifications = false"
        class="mt-2 mb-4 rounded-md shadow-sm bg-white border border-gray-200 overflow-hidden" style="display: none;">
        <div class="flex items-center justify-between px-4 py-2 bg-gray-50">
            <h3 class="text-sm font-medium text-gray-700">Notifikasi Terbaru</h3>
            @if ($unreadCount > 0)
                <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs text-primary hover:text-primary-dark">
                        Tandai semua dibaca
                    </button>
                </form>
            @endif
        </div>

        <div class="max-h-64 overflow-y-auto">
            @forelse($notifications as $notification)
                <div class="p-4 border-b border-gray-100 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }}">
                    <a href="{{ route('notifications.read', $notification->id) }}" class="block">
                        <p class="text-sm font-medium text-gray-900">
                            {{ $notification->data['message'] ?? 'Notification' }}
                        </p>
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-xs text-gray-500">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                            @if (isset($notification->data['link']))
                                <a href="{{ $notification->data['link'] }}"
                                    class="text-xs text-primary hover:text-primary-dark font-medium">
                                    Lihat
                                </a>
                            @endif
                        </div>
                    </a>
                </div>
            @empty
                <div class="py-6 text-center">
                    <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">
                        Belum ada notifikasi
                    </p>
                </div>
            @endforelse
        </div>

        <a href="{{ route('notifications.index') }}"
            class="block px-4 py-2 text-sm text-center text-primary font-medium bg-gray-50 hover:bg-gray-100">
            Lihat semua notifikasi
        </a>
    </div>
</div>
