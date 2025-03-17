<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\DigitalProduct;
use Jenssegers\Agent\Agent;

class OrderController extends Controller
{
    public function __construct()
    {
        // Perbaikan: tidak menggunakan $this->middleware disini
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
                      ->latest()
                      ->paginate(10);

        $agent = new Agent();
        return view($agent->isMobile() ? 
            'pages.mobile.orders.index' : 
            'pages.desktop.orders.index',
            compact('orders')
        );
    }

    public function show(Order $order)
    {
        // Memastikan user hanya bisa melihat pesanannya sendiri
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Load feedback for this order
        $feedback = $order->feedback()->where('user_id', auth()->id())->first();

        $agent = new Agent();
        return view($agent->isMobile() ? 
            'pages.mobile.orders.show' : 
            'pages.desktop.orders.show',
            compact('order', 'feedback')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:digital_products,id',
            'duration' => 'required|integer|min:1',
        ]);

        $product = DigitalProduct::findOrFail($request->product_id);
        
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
