<?php

namespace App\Http\Controllers;

use App\Models\Timeline;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class TimelineController extends Controller
{
    public function index()
    {
        $agent = new Agent();
        $timelines = Timeline::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view(
            $agent->isMobile() ? 'pages.mobile.timeline.index' : 'pages.desktop.timeline.index',
            compact('timelines')
        );
    }
} 