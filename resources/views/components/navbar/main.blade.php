@php
    $navigation = [
        ['route' => 'home', 'name' => 'Beranda'],
        ['route' => 'products', 'name' => 'Produk'],
        ['route' => 'timeline', 'name' => 'Timeline'],
        ['route' => 'faq', 'name' => 'FAQ'],
        ['route' => 'contact', 'name' => 'Kontak'],
    ];
@endphp

<nav class="bg-white shadow-lg fixed w-full top-0 z-50" x-data="{ mobileMenuOpen: false, userDropdownOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                @include('components.navbar.partials.logo')

                <!-- Navigation Links -->
                @include('components.navbar.partials.navigation-links', ['navigation' => $navigation])
            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    @include('components.navbar.partials.user-dropdown')
                @else
                    @include('components.navbar.partials.auth-buttons')
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            @include('components.navbar.partials.mobile-menu-button')
        </div>
    </div>

    <!-- Mobile Menu -->
    @include('components.navbar.partials.mobile-menu', ['navigation' => $navigation])
</nav>

<!-- Spacer untuk fixed navbar -->
<div class="h-16"></div> 