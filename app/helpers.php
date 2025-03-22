<?php

use App\Models\Setting;

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
            \Log::debug("Image path empty, using default: {$default}");
            return asset($default);
        }
        
        $fullPath = storage_path('app/public/' . $path);
        
        // Check if the file exists and return direct URL to it
        if (file_exists($fullPath)) {
            return asset('storage/' . $path);
        }
        
        // If file doesn't exist, log and return default
        \Log::debug("Image not found at {$fullPath}, using default: {$default}");
        return asset($default);
    }
}

if (!function_exists('format_currency')) {
    /**
     * Format a number as currency
     * 
     * @param float $amount
     * @param string|null $currencySymbol
     * @param bool $spaceAfterSymbol
     * @return string
     */
    function format_currency($amount, $currencySymbol = null, $spaceAfterSymbol = false) {
        // Get currency symbol from settings or use the provided one
        if ($currencySymbol === null) {
            $currencySymbol = Setting::get('currency_symbol', 'Rp');
        }
        
        // Format number with thousands separator and decimal places
        $formattedAmount = number_format((float) $amount, 0, ',', '.');
        
        // Add space after currency symbol if needed
        $space = $spaceAfterSymbol ? ' ' : '';
        
        return $currencySymbol . $space . $formattedAmount;
    }
} 