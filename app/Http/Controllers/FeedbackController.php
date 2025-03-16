<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\DigitalProduct;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class FeedbackController extends Controller
{
    public function index()
    {
        $agent = new Agent();
        $feedbacks = Feedback::active()
            ->with('feedbackable')
            ->latest()
            ->paginate(9);
        
        return view(
            $agent->isMobile() ? 'pages.mobile.feedback.index' : 'pages.desktop.feedback.index',
            compact('feedbacks')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'feedbackable_id' => 'nullable|integer',
            'feedbackable_type' => 'nullable|string'
        ]);

        // Validate that the feedbackable exists if provided
        if (!empty($validated['feedbackable_id']) && !empty($validated['feedbackable_type'])) {
            $request->validate([
                'feedbackable_id' => 'exists:' . $validated['feedbackable_type'] . ',id'
            ]);
        }

        $feedback = Feedback::create([
            'name' => $validated['name'],
            'content' => $validated['content'],
            'rating' => $validated['rating'],
            'feedbackable_id' => $validated['feedbackable_id'] ?? null,
            'feedbackable_type' => $validated['feedbackable_type'] ?? null,
            'is_active' => true,
            'order' => Feedback::max('order') + 1
        ]);

        return back()->with('success', 'Thank you for your feedback!');
    }

    public function featured()
    {
        $feedbacks = Feedback::active()
            ->with('feedbackable')
            ->latest()
            ->take(6)
            ->get();
            
        return view('pages.desktop.feedback.featured', compact('feedbacks'));
    }
}
