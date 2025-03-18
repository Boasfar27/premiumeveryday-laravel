<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Feedback;
use Jenssegers\Agent\Agent;
use App\Models\Notification;

class OrderFeedbackController extends Controller
{
    public function __construct()
    {
        // Perbaikan: tidak menggunakan $this->middleware disini
    }
    
    /**
     * Display the form to create a new feedback for an order.
     */
    public function create(Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Ensure the order is completed (payment successful)
        if ($order->status !== 'completed' && $order->status !== 'active') {
            return redirect()->route('user.payments.detail', $order)
                ->with('error', 'You can only leave feedback for completed orders with successful payment.');
        }

        // Check if feedback already exists
        $feedback = $order->feedback()->where('user_id', auth()->id())->first();
        if ($feedback) {
            return redirect()->route('user.orders.feedback.edit', [$order, $feedback])
                ->with('info', 'You have already submitted feedback for this order. You can edit it.');
        }

        $agent = new Agent();
        return view($agent->isMobile() ? 
            'pages.mobile.orders.feedback.create' : 
            'pages.desktop.orders.feedback.create', 
            compact('order')
        );
    }
    
    /**
     * Store a newly created feedback for an order.
     */
    public function store(Request $request, Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Ensure the order is completed (payment successful)
        if ($order->status !== 'completed' && $order->status !== 'active') {
            return redirect()->route('user.payments.detail', $order)
                ->with('error', 'You can only leave feedback for completed orders with successful payment.');
        }

        // Validate the request
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:10|max:1000',
        ]);

        // Get the ordered product
        $product = null;
        if ($order->items->isNotEmpty()) {
            $product = $order->items->first()->orderable;
        }

        // Create the feedback
        $feedback = Feedback::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'feedbackable_id' => $product ? $product->id : null,
            'feedbackable_type' => $product ? get_class($product) : null,
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'rating' => $validated['rating'],
            'content' => $validated['content'],
            'is_active' => true,
        ]);

        // Create notification for admin
        Notification::create([
            'user_id' => null, // Admin notification
            'title' => 'New Feedback Submitted',
            'content' => 'User ' . auth()->user()->name . ' has submitted feedback for order #' . $order->order_number,
            'type' => 'feedback',
            'read_at' => null,
        ]);

        return redirect()->route('user.payments.detail', $order)
            ->with('success', 'Thank you for your feedback!');
    }
    
    /**
     * Show the form to edit feedback for an order
     */
    public function edit(Order $order, Feedback $feedback)
    {
        // Verify this order and feedback belongs to the authenticated user
        if ($order->user_id !== auth()->id() || $feedback->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Verify this feedback belongs to this order
        if ($feedback->order_id !== $order->id) {
            abort(404);
        }
        
        $agent = new Agent();
        return view(
            $agent->isMobile() ? 'pages.mobile.feedback.edit' : 'pages.desktop.feedback.edit',
            compact('order', 'feedback')
        );
    }
    
    /**
     * Update feedback for an order
     */
    public function update(Request $request, Order $order, Feedback $feedback)
    {
        // Verify this order and feedback belongs to the authenticated user
        if ($order->user_id !== auth()->id() || $feedback->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Verify this feedback belongs to this order
        if ($feedback->order_id !== $order->id) {
            abort(404);
        }
        
        // Validate request
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:10|max:1000',
        ]);
        
        // Update feedback
        $feedback->update([
            'rating' => $request->rating,
            'content' => $request->content,
        ]);
        
        // If feedback is linked to a product, update that as well
        if ($feedback->feedbackable_id && $feedback->feedbackable_type) {
            Feedback::where('user_id', auth()->id())
                ->where('feedbackable_id', $feedback->feedbackable_id)
                ->where('feedbackable_type', $feedback->feedbackable_type)
                ->where('order_id', $order->id)
                ->update([
                    'rating' => $request->rating,
                    'content' => $request->content,
                ]);
        }
        
        return redirect()->route('user.payments.detail', $order)
            ->with('success', 'Your feedback has been updated.');
    }
    
    /**
     * Delete feedback for an order
     */
    public function destroy(Order $order, Feedback $feedback)
    {
        // Verify this order and feedback belongs to the authenticated user
        if ($order->user_id !== auth()->id() || $feedback->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Verify this feedback belongs to this order
        if ($feedback->order_id !== $order->id) {
            abort(404);
        }
        
        // Delete feedback
        $feedback->delete();
        
        // If feedback is linked to a product, delete that as well
        if ($feedback->feedbackable_id && $feedback->feedbackable_type) {
            Feedback::where('user_id', auth()->id())
                ->where('feedbackable_id', $feedback->feedbackable_id)
                ->where('feedbackable_type', $feedback->feedbackable_type)
                ->where('order_id', $order->id)
                ->delete();
        }
        
        return redirect()->route('user.payments.detail', $order)
            ->with('success', 'Your feedback has been deleted.');
    }
}
