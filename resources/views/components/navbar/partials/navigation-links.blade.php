<div class="hidden sm:ml-10 sm:flex sm:space-x-8">
    @foreach($navigation as $item)
        <a href="{{ route($item['route']) }}" 
           class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs($item['route']) ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
            {{ $item['name'] }}
        </a>
    @endforeach
</div> 