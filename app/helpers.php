<?php

if (!function_exists('get_image_url')) {
    /**
     * Get the image URL for a given path, checking if it exists
     *
     * @param string|null $path The image path relative to storage/app/public
     * @param string $default The default image if path is empty or file doesn't exist
     * @return string The full URL to the image
     */
    function get_image_url($path, $default = 'images/placeholder.webp')
    {
        if (empty($path)) {
            return asset($default);
        }
        
        $fullPath = storage_path('app/public/' . $path);
        
        // Check if the file exists and return direct URL to it
        if (file_exists($fullPath)) {
            return asset('storage/' . $path);
        }
        
        // If file doesn't exist, return default
        return asset($default);
    }
} 