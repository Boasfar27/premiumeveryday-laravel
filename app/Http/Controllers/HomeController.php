<?php

namespace App\Http\Controllers;

use App\Models\DigitalProduct;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
    public function index()
    {
        $agent = new Agent();
        $products = DigitalProduct::active()
            ->latest()
            ->paginate(8);

        if ($agent->isMobile()) {
            return view('pages.mobile.home', compact('products'));
        }

        return view('pages.desktop.home', compact('products'));
    }
} 