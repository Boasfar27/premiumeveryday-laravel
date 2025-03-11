<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        if (!$user) {
            Log::warning('AdminMiddleware: Unauthorized access attempt');
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Log attempt
        Log::info('AdminMiddleware: Checking admin access', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role
        ]);

        // Cek role admin (role = 1)
        if ((int)$user->role !== 1) {
            Log::warning('AdminMiddleware: Non-admin access attempt', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role
            ]);
            return redirect()->route('user.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        // Cek status aktif
        if (!$user->is_active) {
            Auth::logout();
            Log::warning('AdminMiddleware: Inactive admin access attempt', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);
            return redirect()->route('login')
                ->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
        }

        Log::info('AdminMiddleware: Access granted', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);

        return $next($request);
    }
}
