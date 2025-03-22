<x-filament-panels::page>
    <form wire:submit="saveSettings">
        {{ $this->form }}

        <x-filament::button type="submit" class="mt-6">
            Simpan Pengaturan
        </x-filament::button>
    </form>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize the page
                console.log('Subscription Settings page loaded');
            });
        </script>
    @endpush
</x-filament-panels::page>
