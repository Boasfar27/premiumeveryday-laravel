<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Jenssegers\Agent\Agent;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
                      ->latest()
                      ->paginate(10);

        $agent = new Agent();
        return view($agent->isMobile() ? 
            'pages.user.mobile.orders.index' : 
            'pages.user.desktop.orders.index',
            compact('orders')
        );
    }

    public function show(Order $order)
    {
        // Memastikan user hanya bisa melihat pesanannya sendiri
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $agent = new Agent();
        return view($agent->isMobile() ? 
            'pages.user.mobile.orders.show' : 
            'pages.user.desktop.orders.show',
            compact('order')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'duration' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Hitung total berdasarkan durasi
        $total = $product->price * $request->duration;

        $order = Order::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'duration' => $request->duration,
            'total' => $total,
            'status' => 'pending',
            'order_number' => 'ORD-' . time() . auth()->id(),
        ]);

        return redirect()->route('user.orders.show', $order)
                        ->with('success', 'Pesanan berhasil dibuat');
    }

    public function getStatusColor($status)
    {
        return match($status) {
            'pending' => 'warning',
            'processing' => 'info',
            'active' => 'success',
            'completed' => 'primary',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }
}
