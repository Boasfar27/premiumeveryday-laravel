<!DOCTYPE html>
<html>

<head>
    <title>Image Debug</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .debug-section {
            margin-bottom: 30px;
        }

        .debug-item {
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .debug-image {
            max-width: 200px;
            max-height: 200px;
            border: 1px solid #ddd;
        }

        pre {
            background: #f5f5f5;
            padding: 10px;
            overflow: auto;
        }
    </style>
</head>

<body>
    <h1>Image Debug Info</h1>

    <div class="debug-section">
        <h2>Categories</h2>
        @foreach ($categories as $category)
            <div class="debug-item">
                <h3>{{ $category->name }} (ID: {{ $category->id }})</h3>
                <p><strong>Raw Image Path:</strong> {{ $category->image }}</p>
                <p><strong>Image URL:</strong> {{ $category->image_url }}</p>
                <p><strong>Does File Exist?</strong>
                    {{ file_exists(public_path('storage/' . $category->image)) ? 'Yes' : 'No' }}</p>
                <div>
                    <h4>Image Preview:</h4>
                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="debug-image">
                </div>
            </div>
        @endforeach
    </div>

    <div class="debug-section">
        <h2>Digital Products</h2>
        @foreach ($products as $product)
            <div class="debug-item">
                <h3>{{ $product->name }} (ID: {{ $product->id }})</h3>
                <p><strong>Raw Thumbnail Path:</strong> {{ $product->thumbnail }}</p>
                <p><strong>Thumbnail URL:</strong> {{ $product->thumbnail_url }}</p>
                <p><strong>Does File Exist?</strong>
                    {{ file_exists(public_path('storage/' . $product->thumbnail)) ? 'Yes' : 'No' }}</p>
                <div>
                    <h4>Thumbnail Preview:</h4>
                    <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" class="debug-image">
                </div>
            </div>
        @endforeach
    </div>

    <div class="debug-section">
        <h2>Storage Info</h2>
        <p><strong>Storage Path:</strong> {{ storage_path('app/public') }}</p>
        <p><strong>Public Path:</strong> {{ public_path('storage') }}</p>
        <p><strong>Is Symlink?</strong> {{ is_link(public_path('storage')) ? 'Yes' : 'No' }}</p>
        <p><strong>Symlink Target:</strong>
            {{ is_link(public_path('storage')) ? readlink(public_path('storage')) : 'N/A' }}</p>

        <h3>Environment</h3>
        <p><strong>APP_URL:</strong> {{ env('APP_URL') }}</p>
        <p><strong>Current URL:</strong> {{ url('/') }}</p>
    </div>
</body>

</html>
