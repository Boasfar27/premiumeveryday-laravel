@extends('pages.mobile.layouts.app')

@section('title', 'Notifikasi')

@section('content')
    <div class="py-4">
        <div class="px-4">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-900">Notifikasi</h1>
                <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-primary font-medium">
                        Tandai semua dibaca
                    </button>
                </form>
            </div>

            <div class="mt-4 bg-white rounded-lg overflow-hidden shadow-sm">
                @forelse ($notifications as $notification)
                    <div class="border-b border-gray-100 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }}">
                        <div class="p-4">
                            <div class="flex">
                                <div class="flex-shrink-0 pt-0.5">
                                    @if (isset($notification->data['type']) && $notification->data['type'] === 'order')
                                        <svg class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    @elseif (isset($notification->data['type']) && $notification->data['type'] === 'license')
                                        <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    @elseif (isset($notification->data['type']) && $notification->data['type'] === 'promotion')
                                        <svg class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                        </svg>
                                    @else
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $notification->data['message'] ?? 'Notification' }}
                                    </p>
                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>

                                    <div class="mt-2 flex items-center">
                                        @if (isset($notification->data['link']))
                                            <a href="{{ $notification->data['link'] }}"
                                                class="text-xs font-medium text-primary">
                                                Lihat detail
                                            </a>
                                        @endif

                                        @if (!$notification->read_at)
                                            <a href="{{ route('notifications.read', $notification->id) }}"
                                                class="ml-4 text-xs font-medium text-gray-500">
                                                Tandai dibaca
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center">
                        <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum Ada Notifikasi</h3>
                        <p class="mt-1 text-xs text-gray-500">Anda belum memiliki notifikasi apapun.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-4 px-2">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
@endsection
