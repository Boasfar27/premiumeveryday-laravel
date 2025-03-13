<div class="hidden sm:ml-10 sm:flex sm:space-x-8">
    @foreach ($navigation as $item)
        <a href="{{ route($item['route']) }}"
            class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs($item['route']) ? 'border-pink-500 text-pink-700' : 'border-transparent text-pink-600 hover:border-pink-300 hover:text-pink-800' }}">
            {{ $item['name'] }}
        </a>
    @endforeach
</div>
