<!DOCTYPE html>
<html>

<head>
    <title>Image Test Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .image-container {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 15px;
        }

        .image-container img {
            max-width: 300px;
            height: auto;
            display: block;
            margin-bottom: 10px;
        }

        .details {
            margin-top: 10px;
            font-size: 14px;
        }

        pre {
            background: #f5f5f5;
            padding: 10px;
            overflow: auto;
        }
    </style>
</head>

<body>
    <h1>Direct Image Display Test</h1>

    <div id="categories">
        <h2>Categories</h2>
        @foreach (\App\Models\Category::all() as $category)
            <div class="image-container">
                <h3>{{ $category->name }}</h3>
                <div class="details">
                    <p>Raw Path: {{ $category->image }}</p>
                    <p>URL from accessor: {{ $category->image_url }}</p>
                    <p>Direct URL: {{ asset('storage/' . $category->image) }}</p>
                    <p>Helper URL: {{ get_image_url($category->image) }}</p>
                    <p>File exists: {{ file_exists(storage_path('app/public/' . $category->image)) ? 'Yes' : 'No' }}</p>
                </div>

                <h4>Image Display Tests:</h4>

                <!-- Test 1: Direct URL with onerror -->
                <p>Test 1 (Direct URL with error handling):</p>
                <img src="{{ asset('storage/' . $category->image) }}"
                    onerror="console.error('Test 1 failed: ' + this.src); this.src='{{ asset('images/placeholder.webp') }}'; this.style.border='2px solid red';"
                    onload="console.log('Test 1 success: ' + this.src); this.style.border='2px solid green';"
                    alt="{{ $category->name }}">

                <!-- Test 2: URL from accessor -->
                <p>Test 2 (Accessor URL):</p>
                <img src="{{ $category->image_url }}"
                    onerror="console.error('Test 2 failed: ' + this.src); this.style.border='2px solid red';"
                    onload="console.log('Test 2 success: ' + this.src); this.style.border='2px solid green';"
                    alt="{{ $category->name }}">

                <!-- Test 3: Helper function -->
                <p>Test 3 (Helper function):</p>
                <img src="{{ get_image_url($category->image) }}"
                    onerror="console.error('Test 3 failed: ' + this.src); this.style.border='2px solid red';"
                    onload="console.log('Test 3 success: ' + this.src); this.style.border='2px solid green';"
                    alt="{{ $category->name }}">
            </div>
        @endforeach
    </div>

    <div id="products">
        <h2>Digital Products</h2>
        @foreach (\App\Models\DigitalProduct::all() as $product)
            <div class="image-container">
                <h3>{{ $product->name }}</h3>
                <div class="details">
                    <p>Raw Path: {{ $product->thumbnail }}</p>
                    <p>URL from accessor: {{ $product->thumbnail_url }}</p>
                    <p>Direct URL: {{ asset('storage/' . $product->thumbnail) }}</p>
                    <p>Helper URL: {{ get_image_url($product->thumbnail) }}</p>
                    <p>File exists: {{ file_exists(storage_path('app/public/' . $product->thumbnail)) ? 'Yes' : 'No' }}
                    </p>
                </div>

                <h4>Image Display Tests:</h4>

                <!-- Test 1: Direct URL -->
                <p>Test 1 (Direct URL with error handling):</p>
                <img src="{{ asset('storage/' . $product->thumbnail) }}"
                    onerror="console.error('Test 1 failed: ' + this.src); this.src='{{ asset('images/placeholder.webp') }}'; this.style.border='2px solid red';"
                    onload="console.log('Test 1 success: ' + this.src); this.style.border='2px solid green';"
                    alt="{{ $product->name }}">

                <!-- Test 2: URL from accessor -->
                <p>Test 2 (Accessor URL):</p>
                <img src="{{ $product->thumbnail_url }}"
                    onerror="console.error('Test 2 failed: ' + this.src); this.style.border='2px solid red';"
                    onload="console.log('Test 2 success: ' + this.src); this.style.border='2px solid green';"
                    alt="{{ $product->name }}">

                <!-- Test 3: Helper function -->
                <p>Test 3 (Helper function):</p>
                <img src="{{ get_image_url($product->thumbnail) }}"
                    onerror="console.error('Test 3 failed: ' + this.src); this.style.border='2px solid red';"
                    onload="console.log('Test 3 success: ' + this.src); this.style.border='2px solid green';"
                    alt="{{ $product->name }}">
            </div>
        @endforeach
    </div>

    <div id="browser_info">
        <h2>Browser Environment Info</h2>
        <p>App URL: {{ env('APP_URL') }}</p>
        <p>Current URL: {{ url('/') }}</p>
        <p>Storage URL: {{ asset('storage') }}</p>
        <p>Images URL: {{ asset('images') }}</p>
    </div>

    <script>
        // Add debugging for image loading issues
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, checking images...');

            // Check if storage directory is accessible
            fetch('{{ asset('storage') }}')
                .then(response => {
                    console.log('Storage directory fetch status:', response.status);
                    return response.text();
                })
                .catch(error => {
                    console.error('Storage directory fetch failed:', error);
                });

            // Log all image errors
            const allImages = document.querySelectorAll('img');
            allImages.forEach(img => {
                img.addEventListener('error', function() {
                    console.error('Image failed to load:', this.src);
                });

                img.addEventListener('load', function() {
                    console.log('Image loaded successfully:', this.src);
                });
            });
        });
    </script>
</body>

</html>
