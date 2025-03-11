<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (!Auth::check() || !Auth::user()->email_verified_at) {
            return redirect()->route('verification.notice');
        }
    }

    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (!Auth::check() || !Auth::user()->email_verified_at) {
            return redirect()->route('verification.notice');
        }

        $agent = new Agent();
        $user = auth()->user();
        
        return view($agent->isMobile() ? 'pages.mobile.user.dashboard' : 'pages.desktop.user.dashboard', [
            'user' => $user
        ]);
    }
}
