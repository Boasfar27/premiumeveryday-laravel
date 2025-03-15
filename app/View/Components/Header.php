<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class Header extends Component
{
    public $notifications;
    public $unreadCount;
    public $user;

    public function __construct()
    {
        $this->user = Auth::user();
        
        if (Auth::check()) {
            $this->notifications = Notification::active()
                ->orderBy('order')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
            
            $this->unreadCount = Notification::active()
                ->unreadByUser(Auth::id())
                ->count();
        } else {
            $this->notifications = collect();
            $this->unreadCount = 0;
        }
    }

    public function render()
    {
        return view('components.header', [
            'user' => $this->user,
            'notifications' => $this->notifications,
            'unreadCount' => $this->unreadCount
        ]);
    }
} 