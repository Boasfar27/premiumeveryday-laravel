<?php

namespace App\Http\Controllers;

use App\Models\DigitalProduct;
use App\Models\Review;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
    public function index()
    {
        $agent = new Agent();
        $featuredProducts = DigitalProduct::active()
            ->where('is_featured', true)
            ->latest()
            ->take(6)
            ->get();
            
        $streamingVideoProducts = DigitalProduct::active()
            ->whereHas('category', function($query) {
                $query->where('slug', 'streaming-video');
            })
            ->latest()
            ->take(4)
            ->get();
            
        $streamingMusicProducts = DigitalProduct::active()
            ->whereHas('category', function($query) {
                $query->where('slug', 'streaming-music');
            })
            ->latest()
            ->take(4)
            ->get();
            
        // Get 6 latest testimonials with rating >= 4
        $testimonials = Review::where('is_active', true)
            ->where('rating', '>=', 4)
            ->latest()
            ->take(6)
            ->get();
            
        // Get General FAQs
        $generalFaqs = \App\Models\Faq::where('category', 'general')
            ->where('is_active', true)
            ->orderBy('position')
            ->take(4)
            ->get();
            
        // Get Streaming FAQs
        $streamingFaqs = \App\Models\Faq::where('category', 'streaming')
            ->where('is_active', true)
            ->orderBy('position')
            ->take(4)
            ->get();
            
        // Get Contacts
        $contacts = \App\Models\Contact::where('is_active', true)->get();

        if ($agent->isMobile()) {
            return view('pages.mobile.home', compact(
                'featuredProducts', 
                'streamingVideoProducts', 
                'streamingMusicProducts', 
                'testimonials',
                'generalFaqs',
                'streamingFaqs',
                'contacts'
            ));
        }

        return view('pages.desktop.home', compact(
            'featuredProducts', 
            'streamingVideoProducts', 
            'streamingMusicProducts', 
            'testimonials',
            'generalFaqs',
            'streamingFaqs',
            'contacts'
        ));
    }
} 