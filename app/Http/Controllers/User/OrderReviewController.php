<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class OrderReviewController extends Controller
{
    /**
     * Show the form for creating a new review.
     */
    public function create(Order $order)
    {
        // Memastikan order ini milik user yang sedang login
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Cek apakah order sudah memiliki review
        $existingReview = $order->reviews()->where('user_id', Auth::id())->first();
        if ($existingReview) {
            return redirect()->route('user.payments.review.edit', ['order' => $order->id, 'review' => $existingReview->id]);
        }

        $agent = new Agent();
        return view('pages.' . ($agent->isMobile() ? 'mobile' : 'desktop') . '.reviews.create', [
            'order' => $order,
            'existingReview' => null
        ]);
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Order $order)
    {
        // Memastikan order ini milik user yang sedang login
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:10',
        ]);

        // Cek apakah sudah ada review sebelumnya
        $existingReview = $order->reviews()->where('user_id', Auth::id())->first();
        if ($existingReview) {
            return redirect()->route('user.payments.review.edit', ['order' => $order->id, 'review' => $existingReview->id]);
        }

        // Membuat review baru
        $review = new Review();
        $review->user_id = Auth::id();
        $review->order_id = $order->id;
        $review->name = Auth::user()->name;
        $review->rating = $request->rating;
        $review->content = $request->content;
        $review->is_active = true;
        $review->save();

        return redirect()->route('user.payments.detail', $order->id)->with('success', 'Ulasan berhasil dikirim!');
    }

    /**
     * Show the form for editing the specified review.
     */
    public function edit(Order $order, Review $review)
    {
        // Memastikan order dan review ini milik user yang sedang login
        if ($order->user_id !== Auth::id() || $review->user_id !== Auth::id()) {
            abort(403);
        }

        $agent = new Agent();
        return view('pages.' . ($agent->isMobile() ? 'mobile' : 'desktop') . '.reviews.edit', [
            'order' => $order,
            'review' => $review
        ]);
    }

    /**
     * Update the specified review in storage.
     */
    public function update(Request $request, Order $order, Review $review)
    {
        // Memastikan order dan review ini milik user yang sedang login
        if ($order->user_id !== Auth::id() || $review->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:10',
        ]);

        // Update review
        $review->rating = $request->rating;
        $review->content = $request->content;
        $review->save();

        return redirect()->route('user.payments.detail', $order->id)->with('success', 'Ulasan berhasil diperbarui!');
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Order $order, Review $review)
    {
        // Memastikan order dan review ini milik user yang sedang login
        if ($order->user_id !== Auth::id() || $review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();

        return redirect()->route('user.payments.detail', $order->id)->with('success', 'Review berhasil dihapus!');
    }
}
