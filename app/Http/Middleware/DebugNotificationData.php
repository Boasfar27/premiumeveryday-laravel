<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class DebugNotificationData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log semua request ke URL admin
        if (str_contains($request->url(), '/admin/')) {
            Log::info('Admin URL request', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'user_id' => Auth::id(),
                'user_role' => Auth::user()?->role,
                'path' => $request->path(),
                'segments' => $request->segments(),
            ]);
        }
        
        // Log semua request untuk notifikasi
        if (str_contains($request->path(), 'notifications')) {
            Log::info('Notification request', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'user_id' => Auth::id(),
                'user_role' => Auth::user()?->role,
                'path' => $request->path(),
                'segments' => $request->segments(),
            ]);
        }

        return $next($request);
    }
}
