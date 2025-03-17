<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Feedback;
use Jenssegers\Agent\Agent;

class OrderFeedbackController extends Controller
{
    public function __construct()
    {
        // Perbaikan: tidak menggunakan $this->middleware disini
    }
    
    /**
     * Show the form to create feedback for an order
     */
    public function create(Order $order)
    {
        // Verify this order belongs to the authenticated user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Check if order is completed/active and can receive feedback
        if (!in_array($order->status, ['completed', 'active'])) {
            return back()->with('error', 'You can only leave feedback for completed or active orders.');
        }
        
        // Check if feedback already exists
        $existingFeedback = $order->feedback()->where('user_id', auth()->id())->first();
        
        $agent = new Agent();
        return view(
            $agent->isMobile() ? 'pages.mobile.feedback.create' : 'pages.user.desktop.feedback.create',
            compact('order', 'existingFeedback')
        );
    }
    
    /**
     * Store feedback for an order
     */
    public function store(Request $request, Order $order)
    {
        // Verify this order belongs to the authenticated user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Validate request
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:10|max:1000',
        ]);
        
        // Check if order is completed/active and can receive feedback
        if (!in_array($order->status, ['completed', 'active'])) {
            return back()->with('error', 'You can only leave feedback for completed or active orders.');
        }
        
        // Create or update feedback
        $feedback = $order->feedback()->updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'rating' => $request->rating,
                'content' => $request->content,
                'is_active' => true,
            ]
        );
        
        // If order has products, link feedback to those products
        if ($order->items->isNotEmpty()) {
            foreach ($order->items as $item) {
                if ($item->product) {
                    // Create additional feedback for the specific product
                    Feedback::updateOrCreate(
                        [
                            'user_id' => auth()->id(),
                            'feedbackable_id' => $item->product->id,
                            'feedbackable_type' => get_class($item->product)
                        ],
                        [
                            'name' => auth()->user()->name,
                            'email' => auth()->user()->email,
                            'rating' => $request->rating,
                            'content' => $request->content,
                            'order_id' => $order->id,
                            'is_active' => true,
                        ]
                    );
                }
            }
        }
        
        return redirect()->route('user.orders.show', $order)
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
        
        return redirect()->route('user.orders.show', $order)
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
        
        return redirect()->route('user.orders.show', $order)
            ->with('success', 'Your feedback has been deleted.');
    }
}
