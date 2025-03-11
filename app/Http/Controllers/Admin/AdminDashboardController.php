<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Models\User;
use App\Models\Order;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $agent = new Agent();
        $admin = auth()->user();
        
        // Get statistics
        $totalUsers = User::where('role', 0)->count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        
        // Get latest orders with user details
        $latestOrders = Order::with('user')
                            ->latest()
                            ->take(5)
                            ->get();

        $viewData = [
            'admin' => $admin,
            'totalUsers' => $totalUsers,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'latestOrders' => $latestOrders
        ];
        
        return view($agent->isMobile() ? 'pages.mobile.admin.dashboard' : 'pages.desktop.admin.dashboard', $viewData);
    }

    public function toggleUserStatus(User $user)
    {
        if ($user->role === 1) {
            return back()->with('error', 'Tidak dapat mengubah status admin.');
        }

        $user->update([
            'is_active' => !$user->is_active
        ]);

        return back()->with('success', 'Status user berhasil diperbarui.');
    }
}
