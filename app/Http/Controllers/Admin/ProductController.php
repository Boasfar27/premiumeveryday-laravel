<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'admin']);
    }

    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'sharing_price' => 'required|numeric|min:0',
            'private_price' => 'required|numeric|min:0',
            'sharing_description' => 'required|string',
            'private_description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
            'order' => 'integer|min:0',
            'sharing_discount' => 'integer|min:0|max:100',
            'private_discount' => 'integer|min:0|max:100',
            'is_promo' => 'boolean',
            'promo_ends_at' => 'nullable|date|after:now'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Set default values
        $validated['is_active'] = $request->has('is_active');
        $validated['is_promo'] = $request->has('is_promo');
        $validated['sharing_discount'] = $validated['sharing_discount'] ?? 0;
        $validated['private_discount'] = $validated['private_discount'] ?? 0;
        $validated['order'] = $validated['order'] ?? 0;

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'sharing_price' => 'required|numeric|min:0',
            'private_price' => 'required|numeric|min:0',
            'sharing_description' => 'required|string',
            'private_description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
            'order' => 'integer|min:0',
            'sharing_discount' => 'integer|min:0|max:100',
            'private_discount' => 'integer|min:0|max:100',
            'is_promo' => 'boolean',
            'promo_ends_at' => 'nullable|date|after:now'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Set boolean values
        $validated['is_active'] = $request->has('is_active');
        $validated['is_promo'] = $request->has('is_promo');
        
        // Set default values if not provided
        $validated['sharing_discount'] = $validated['sharing_discount'] ?? 0;
        $validated['private_discount'] = $validated['private_discount'] ?? 0;
        $validated['order'] = $validated['order'] ?? 0;

        // Clear promo_ends_at if not in promo
        if (!$validated['is_promo']) {
            $validated['promo_ends_at'] = null;
        }

        $product->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }
} 