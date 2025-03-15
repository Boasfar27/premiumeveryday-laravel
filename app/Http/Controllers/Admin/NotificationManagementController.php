<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NotificationManagementController extends Controller
{
    public function index()
    {
        $notifications = Notification::orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:promo,product,system',
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
            'link' => 'nullable|url',
            'is_public' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_active' => 'boolean',
            'order' => 'integer|min:0'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('notifications', 'public');
            $validated['image_url'] = Storage::url($path);
        }

        Notification::create($validated);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification created successfully');
    }

    public function edit(Notification $notification)
    {
        return view('admin.notifications.edit', compact('notification'));
    }

    public function update(Request $request, Notification $notification)
    {
        $validated = $request->validate([
            'type' => 'required|in:promo,product,system',
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
            'link' => 'nullable|url',
            'is_public' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_active' => 'boolean',
            'order' => 'integer|min:0'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($notification->image_url) {
                Storage::delete(str_replace('/storage/', 'public/', $notification->image_url));
            }
            
            $path = $request->file('image')->store('notifications', 'public');
            $validated['image_url'] = Storage::url($path);
        }

        $notification->update($validated);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification updated successfully');
    }

    public function destroy(Notification $notification)
    {
        if ($notification->image_url) {
            Storage::delete(str_replace('/storage/', 'public/', $notification->image_url));
        }

        $notification->delete();

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification deleted successfully');
    }
} 