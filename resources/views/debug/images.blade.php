@extends('layouts.app')

@section('title', 'Debug Images')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Image Debugging Page</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-end mb-4">
            <form action="{{ route('debug.fix-images') }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Fix Common Image Issues
                </button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">System Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <h3 class="font-medium mb-2">Storage Paths</h3>
                    <div class="space-y-1 text-sm">
                        <p>
                            <span class="font-medium">Storage Path:</span>
                            {{ storage_path('app/public') }}
                            <span class="ml-2 {{ $storagePathExists ? 'text-green-500' : 'text-red-500' }}">
                                {{ $storagePathExists ? '✓' : '✗' }}
                            </span>
                        </p>
                        <p>
                            <span class="font-medium">Public Storage Link:</span>
                            {{ public_path('storage') }}
                            <span class="ml-2 {{ $storageLinkExists ? 'text-green-500' : 'text-red-500' }}">
                                {{ $storageLinkExists ? '✓' : '✗' }}
                            </span>
                        </p>
                        <p>
                            <span class="font-medium">Thumbnails Directory:</span>
                            {{ storage_path('app/public/products/thumbnails') }}
                            <span class="ml-2 {{ $thumbnailDirExists ? 'text-green-500' : 'text-red-500' }}">
                                {{ $thumbnailDirExists ? '✓' : '✗' }}
                            </span>
                        </p>
                        <p>
                            <span class="font-medium">Placeholder Image:</span>
                            {{ public_path('images/placeholder.webp') }}
                            <span class="ml-2 {{ $placeholderExists ? 'text-green-500' : 'text-red-500' }}">
                                {{ $placeholderExists ? '✓' : '✗' }}
                            </span>
                        </p>
                    </div>
                </div>

                <div>
                    <h3 class="font-medium mb-2">Environment</h3>
                    <div class="space-y-1 text-sm">
                        <p><span class="font-medium">APP_URL:</span> {{ config('app.url') }}</p>
                        <p><span class="font-medium">FILESYSTEM_DISK:</span> {{ config('filesystems.default') }}</p>
                        <p><span class="font-medium">Current URL:</span> {{ url()->current() }}</p>
                        <p><span class="font-medium">Symlink Target:</span>
                            {{ $storageLinkExists ? readlink(public_path('storage')) : 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Digital Products ({{ $products->count() }})</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($products as $product)
                    <div class="border rounded-lg overflow-hidden">
                        <div class="bg-gray-50 p-4">
                            <h3 class="font-medium text-lg mb-2">{{ $product->name }}</h3>
                            <p class="text-xs text-gray-500 mb-2">ID: {{ $product->id }}</p>

                            <div class="space-y-1 text-xs mb-4">
                                <p>
                                    <span class="font-medium">Raw Path:</span>
                                    <code class="bg-gray-200 px-1 rounded">{{ $product->thumbnail ?: 'null' }}</code>
                                </p>
                                <p>
                                    <span class="font-medium">File Exists?</span>
                                    @if ($product->thumbnail)
                                        <span
                                            class="{{ file_exists(storage_path('app/public/' . $product->thumbnail)) ? 'text-green-500' : 'text-red-500' }}">
                                            {{ file_exists(storage_path('app/public/' . $product->thumbnail)) ? 'Yes' : 'No' }}
                                        </span>
                                    @else
                                        <span class="text-yellow-500">No path defined</span>
                                    @endif
                                </p>
                            </div>

                            <div class="border rounded overflow-hidden bg-white">
                                <div class="bg-gray-100 text-xs p-1 font-medium">Thumbnail Preview:</div>
                                <div class="h-40 bg-gray-200 flex items-center justify-center relative">
                                    <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                                        class="max-h-40 max-w-full"
                                        onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}'; this.classList.add('error-image'); console.error('Failed to load: ' + this.src);">
                                    <div class="absolute bottom-0 right-0 bg-black bg-opacity-75 text-white text-xs px-1">
                                        {{ preg_match('/placeholder\.webp$/', $product->thumbnail_url) ? 'Placeholder' : 'Actual Image' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Categories ({{ $categories->count() }})</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($categories as $category)
                    <div class="border rounded-lg overflow-hidden">
                        <div class="bg-gray-50 p-4">
                            <h3 class="font-medium text-lg mb-2">{{ $category->name }}</h3>
                            <p class="text-xs text-gray-500 mb-2">ID: {{ $category->id }}</p>

                            <div class="space-y-1 text-xs mb-4">
                                <p>
                                    <span class="font-medium">Raw Path:</span>
                                    <code class="bg-gray-200 px-1 rounded">{{ $category->image ?: 'null' }}</code>
                                </p>
                                <p>
                                    <span class="font-medium">File Exists?</span>
                                    @if ($category->image)
                                        <span
                                            class="{{ file_exists(storage_path('app/public/' . $category->image)) ? 'text-green-500' : 'text-red-500' }}">
                                            {{ file_exists(storage_path('app/public/' . $category->image)) ? 'Yes' : 'No' }}
                                        </span>
                                    @else
                                        <span class="text-yellow-500">No path defined</span>
                                    @endif
                                </p>
                            </div>

                            <div class="border rounded overflow-hidden bg-white">
                                <div class="bg-gray-100 text-xs p-1 font-medium">Image Preview:</div>
                                <div class="h-40 bg-gray-200 flex items-center justify-center relative">
                                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                                        class="max-h-40 max-w-full"
                                        onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}'; this.classList.add('error-image');">
                                    <div class="absolute bottom-0 right-0 bg-black bg-opacity-75 text-white text-xs px-1">
                                        {{ preg_match('/placeholder\.webp$/', $category->image_url) ? 'Placeholder' : 'Actual Image' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
