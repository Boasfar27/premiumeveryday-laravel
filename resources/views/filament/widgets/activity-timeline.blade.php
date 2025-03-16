<x-filament::widget>
    <x-filament::card>
        <div class="space-y-4">
            <div class="text-lg font-medium">
                Recent Activities
            </div>

            <div class="space-y-4">
                @foreach ($activities as $activity)
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-3 h-3 bg-primary-500 rounded-full"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $activity->title }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $activity->description }}
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $activity->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
