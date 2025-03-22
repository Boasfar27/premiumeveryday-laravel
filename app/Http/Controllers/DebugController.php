<?php

namespace App\Http\Controllers;

use App\Models\DigitalProduct;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DebugController extends Controller
{
    /**
     * Show the image debugging page
     */
    public function images()
    {
        $products = DigitalProduct::all();
        $categories = Category::all();
        
        // Check storage and symlinks
        $storagePathExists = is_dir(storage_path('app/public'));
        $storageLinkExists = is_link(public_path('storage'));
        $thumbnailDirExists = is_dir(storage_path('app/public/products/thumbnails'));
        $placeholderExists = file_exists(public_path('images/placeholder.webp'));
        
        return view('debug.images', compact(
            'products', 
            'categories',
            'storagePathExists',
            'storageLinkExists',
            'thumbnailDirExists',
            'placeholderExists'
        ));
    }
    
    /**
     * Fix common image issues
     */
    public function fixImages()
    {
        // 1. Recreate the storage link if needed
        if (!is_link(public_path('storage'))) {
            \Artisan::call('storage:link');
        }
        
        // 2. Create thumbnails directory if it doesn't exist
        if (!is_dir(storage_path('app/public/products/thumbnails'))) {
            Storage::disk('public')->makeDirectory('products/thumbnails');
        }
        
        return redirect()->route('debug.images')->with('success', 'Attempted to fix common image issues');
    }
}
