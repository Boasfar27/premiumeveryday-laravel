<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the reviews.
     */
    public function index()
    {
        return view('pages.' . getDevice() . '.reviews.index', [
            'reviews' => Review::with('user', 'order')->where('is_active', true)->latest()->paginate(10)
        ]);
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:10',
        ]);

        // Memastikan user hanya bisa memberikan review untuk pesanan mereka sendiri
        $order = Auth::user()->orders()->findOrFail($request->order_id);

        // Membuat review baru
        $review = new Review();
        $review->user_id = Auth::id();
        $review->order_id = $order->id;
        $review->name = Auth::user()->name;
        $review->rating = $request->rating;
        $review->content = $request->content;
        $review->is_active = true;
        $review->save();

        return redirect()->back()->with('success', 'Review berhasil dikirim!');
    }
}
