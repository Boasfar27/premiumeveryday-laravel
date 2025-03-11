<footer class="bg-primary text-white">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Brand -->
            @include('components.footer.brand')

            <!-- Tautan -->
            @include('components.footer.links')

            <!-- Kontak -->
            @include('components.footer.contact')

            <!-- Social Media -->
            @include('components.footer.social')
        </div>

        <div class="mt-8 border-t border-gray-700 pt-8">
            <p class="text-center text-sm text-gray-300">
                © {{ date('Y') }} Premium Everyday. All rights reserved.
            </p>
        </div>
    </div>
</footer> 