<?php

namespace App\Http\Controllers;

use App\Models\DigitalProduct;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;

class DigitalProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $agent = new Agent();
        
        $query = DigitalProduct::with('category')
            ->where('is_active', true);
            
        // Filter by category if provided
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        // Filter by search term if provided
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Sort products
        $sortBy = $request->sort ?? 'newest';
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }
        
        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();
        
        return view(
            $agent->isMobile() ? 'pages.mobile.products.index' : 'pages.desktop.products.index',
            compact('products', 'categories')
        );
    }
    
    /**
     * Display streaming video products.
     */
    public function streamingVideo()
    {
        $agent = new Agent();
        
        $products = DigitalProduct::with('category')
            ->whereHas('category', function($query) {
                $query->where('slug', 'streaming-video');
            })
            ->where('is_active', true)
            ->latest()
            ->paginate(12);
            
        $categories = Category::where('is_active', true)->get();
        $currentCategory = Category::where('slug', 'streaming-video')->first();
        
        return view(
            $agent->isMobile() ? 'pages.mobile.products.index' : 'pages.desktop.products.index',
            compact('products', 'categories', 'currentCategory')
        );
    }
    
    /**
     * Display streaming music products.
     */
    public function streamingMusic()
    {
        $agent = new Agent();
        
        $products = DigitalProduct::with('category')
            ->whereHas('category', function($query) {
                $query->where('slug', 'streaming-music');
            })
            ->where('is_active', true)
            ->latest()
            ->paginate(12);
            
        $categories = Category::where('is_active', true)->get();
        $currentCategory = Category::where('slug', 'streaming-music')->first();
        
        return view(
            $agent->isMobile() ? 'pages.mobile.products.index' : 'pages.desktop.products.index',
            compact('products', 'categories', 'currentCategory')
        );
    }
    
    /**
     * Display productivity tools products.
     */
    public function productivityTools()
    {
        $agent = new Agent();
        
        $products = DigitalProduct::with('category')
            ->whereHas('category', function($query) {
                $query->where('slug', 'productivity-tools');
            })
            ->where('is_active', true)
            ->latest()
            ->paginate(12);
            
        $categories = Category::where('is_active', true)->get();
        $currentCategory = Category::where('slug', 'productivity-tools')->first();
        
        return view(
            $agent->isMobile() ? 'pages.mobile.products.index' : 'pages.desktop.products.index',
            compact('products', 'categories', 'currentCategory')
        );
    }
    
    /**
     * Display premium software products.
     */
    public function premiumSoftware()
    {
        $agent = new Agent();
        
        $products = DigitalProduct::with('category')
            ->whereHas('category', function($query) {
                $query->where('slug', 'premium-software');
            })
            ->where('is_active', true)
            ->latest()
            ->paginate(12);
            
        $categories = Category::where('is_active', true)->get();
        $currentCategory = Category::where('slug', 'premium-software')->first();
        
        return view(
            $agent->isMobile() ? 'pages.mobile.products.index' : 'pages.desktop.products.index',
            compact('products', 'categories', 'currentCategory')
        );
    }

    /**
     * Display the specified product.
     */
    public function show(DigitalProduct $product)
    {
        $agent = new Agent();
        
        // Check if product is active
        if (!$product->is_active) {
            abort(404);
        }
        
        // Add to recently viewed
        $recentlyViewed = Session::get('recently_viewed', []);
        
        // Remove if already in the list
        if (($key = array_search($product->id, $recentlyViewed)) !== false) {
            unset($recentlyViewed[$key]);
        }
        
        // Add to the beginning of the array
        array_unshift($recentlyViewed, $product->id);
        
        // Keep only the last 10 items
        $recentlyViewed = array_slice($recentlyViewed, 0, 10);
        
        Session::put('recently_viewed', $recentlyViewed);
        
        // Get related products
        $relatedProducts = DigitalProduct::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();
            
        // Get reviews for this product
        $reviews = $product->reviews()
            ->where('is_active', true)
            ->latest()
            ->take(5)
            ->get();
        
        return view(
            $agent->isMobile() ? 'pages.mobile.products.show' : 'pages.desktop.products.show',
            compact('product', 'relatedProducts', 'reviews')
        );
    }
} 