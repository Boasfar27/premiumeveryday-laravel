<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'admin']);
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'recent_orders' => Order::with('user')
                ->latest()
                ->take(5)
                ->get()
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
} 