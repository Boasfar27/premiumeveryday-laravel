<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::latest()->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons,code|max:50',
            'discount' => 'required|numeric|min:0',
            'type' => 'required|in:percentage,fixed',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date|after:today',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Coupon::create($validated);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        return view('admin.coupons.show', compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'discount' => 'required|numeric|min:0',
            'type' => 'required|in:percentage,fixed',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date|after:today',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $coupon->update($validated);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon deleted successfully.');
    }

    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:coupons,code'
        ]);

        $coupon = Coupon::where('code', $request->code)->first();

        // Check if coupon is active
        if (!$coupon->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'This coupon is not active.'
            ], 422);
        }

        // Check expiration
        if ($coupon->expires_at && Carbon::now()->gt($coupon->expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'This coupon has expired.'
            ], 422);
        }

        // Check max uses
        if ($coupon->max_uses && $coupon->used_count >= $coupon->max_uses) {
            return response()->json([
                'success' => false,
                'message' => 'This coupon has reached its usage limit.'
            ], 422);
        }

        // Get cart total from session
        $cartTotal = session('cart_total', 0);

        // Calculate discount
        $discount = $coupon->type === 'percentage' 
            ? ($cartTotal * $coupon->discount / 100)
            : $coupon->discount;

        // Store discount in session
        session([
            'coupon' => [
                'code' => $coupon->code,
                'discount' => $discount,
                'type' => $coupon->type
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully.',
            'discount' => $discount,
            'new_total' => $cartTotal - $discount
        ]);
    }
}
