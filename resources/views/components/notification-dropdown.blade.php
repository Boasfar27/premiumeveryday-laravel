@props(['notifications' => [], 'unreadCount' => 0])

<div x-data="{
    open: false,
    notifications: @js($notifications),
    unreadCount: @js($unreadCount),
    async markAsRead(id) {
        try {
            const response = await fetch(`/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                }
            });
            const data = await response.json();
            if (data.success) {
                this.unreadCount = data.unread_count;
                this.notifications = this.notifications.map(n =>
                    n.id === id ? { ...n, read: true } : n
                );
            }
        } catch (error) {
            console.error('Error marking notification as read:', error);
        }
    },
    async markAllAsRead() {
        try {
            const response = await fetch('/notifications/read-all', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                }
            });
            const data = await response.json();
            if (data.success) {
                this.unreadCount = 0;
                this.notifications = this.notifications.map(n => ({ ...n, read: true }));
            }
        } catch (error) {
            console.error('Error marking all notifications as read:', error);
        }
    }
}" @click.away="open = false" class="relative">
    <button @click="open = !open" type="button" class="relative p-1 text-gray-600 hover:text-gray-900 focus:outline-none">
        <span class="sr-only">View notifications</span>
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
            </path>
        </svg>
        <template x-if="unreadCount > 0">
            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500"
                x-text="unreadCount > 9 ? '9+' : unreadCount"></span>
        </template>
    </button>

    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none">
        <div class="px-4 py-3">
            <div class="flex justify-between items-center">
                <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
                <template x-if="unreadCount > 0">
                    <button @click="markAllAsRead" class="text-xs text-primary hover:text-primary-dark">Mark all as
                        read</button>
                </template>
            </div>
        </div>

        <div class="max-h-96 overflow-y-auto">
            <template x-if="notifications.length === 0">
                <div class="px-4 py-3">
                    <p class="text-sm text-gray-500">No notifications</p>
                </div>
            </template>

            <template x-for="notification in notifications" :key="notification.id">
                <div class="px-4 py-3 hover:bg-gray-50 cursor-pointer" :class="{ 'bg-blue-50': !notification.read }"
                    @click="markAsRead(notification.id)">
                    <div class="flex items-start">
                        <template x-if="notification.image_url">
                            <img :src="notification.image_url" class="h-10 w-10 rounded-lg object-cover mr-3"
                                alt="">
                        </template>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900" x-text="notification.title"></p>
                            <p class="text-sm text-gray-500 line-clamp-2" x-text="notification.content"></p>
                            <p class="text-xs text-gray-400 mt-1"
                                x-text="new Date(notification.created_at).toLocaleDateString()"></p>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div class="px-4 py-3">
            <a href="#" class="text-sm text-primary hover:text-primary-dark">View all notifications</a>
        </div>
    </div>
</div>
