<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::active()
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => Notification::active()->unreadByUser(Auth::id())->count()
        ]);
    }

    public function markAsRead(Request $request)
    {
        $notification = Notification::findOrFail($request->notification_id);
        
        $notification->readers()->attach(Auth::id(), [
            'read_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'unread_count' => Notification::active()->unreadByUser(Auth::id())->count()
        ]);
    }

    public function markAllAsRead()
    {
        $notifications = Notification::active()->unreadByUser(Auth::id())->get();
        
        foreach ($notifications as $notification) {
            $notification->readers()->attach(Auth::id(), [
                'read_at' => now()
            ]);
        }

        return response()->json([
            'success' => true,
            'unread_count' => 0
        ]);
    }
} 