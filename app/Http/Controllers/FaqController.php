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
        
        return view('components.faq.index', compact('faqs'));
    }
} 