<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        $data = [
            'totalOrders' => Order::where('user_id', $user->id)->count(),
            'activeOrders' => Order::where('user_id', $user->id)
                                 ->whereIn('status', ['active', 'processing'])
                                 ->count(),
            'totalSpent' => Order::where('user_id', $user->id)
                                ->where('status', '!=', 'cancelled')
                                ->sum('total'),
            'recentOrders' => Order::where('user_id', $user->id)
                                  ->latest()
                                  ->take(5)
                                  ->get()
        ];

        $agent = new Agent();
        return view($agent->isMobile() ? 
            'pages.user.mobile.dashboard' : 
            'pages.user.desktop.dashboard', 
            $data
        );
    }

    public function profile()
    {
        $agent = new Agent();
        return view($agent->isMobile() ? 
            'pages.user.mobile.profile' : 
            'pages.user.desktop.profile'
        );
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success', 'Password berhasil diperbarui');
    }
}
