<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class FaqController extends Controller
{
    public function index()
    {
        $agent = new Agent();
        $faqs = Faq::where('is_active', true)->orderBy('order')->get();
        
        // Get all categories that have active FAQs
        $categories = $faqs->pluck('category')->unique()->values()->all();
        
        if ($agent->isMobile()) {
            return view('pages.mobile.faq.index', compact('faqs', 'categories'));
        }
        
        return view('pages.desktop.faq.index', compact('faqs', 'categories'));
    }
} 