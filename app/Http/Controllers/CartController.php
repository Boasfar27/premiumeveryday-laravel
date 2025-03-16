<?php

namespace App\Http\Controllers;

use App\Models\DigitalProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display the cart page
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $products = [];
        $subtotal = 0;
        
        // Get product details for each item in cart
        foreach ($cart as $id => $item) {
            $product = DigitalProduct::find($id);
            if ($product) {
                $products[] = [
                    'id' => $id,
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'total' => $product->getDiscountedPrice() * $item['quantity']
                ];
                $subtotal += $product->getDiscountedPrice() * $item['quantity'];
            }
        }
        
        // Calculate tax and total
        $discount = Session::get('discount', 0);
        $tax = ($subtotal - $discount) * 0.11; // 11% tax
        $total = $subtotal - $discount + $tax;
        
        // Get recently viewed products
        $recentlyViewed = Session::get('recently_viewed', []);
        $recentProducts = DigitalProduct::whereIn('id', $recentlyViewed)
            ->where('is_active', true)
            ->take(4)
            ->get();
            
        // Determine if desktop or mobile view
        $agent = new \Jenssegers\Agent\Agent();
        $view = $agent->isMobile() ? 'pages.mobile.cart.index' : 'pages.desktop.cart.index';
        
        return view($view, compact('products', 'subtotal', 'discount', 'tax', 'total', 'recentProducts'));
    }
    
    /**
     * Add a product to the cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:digital_products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $productId = $request->product_id;
        $quantity = $request->quantity;
        
        // Get current cart
        $cart = Session::get('cart', []);
        
        // Add or update product in cart
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'quantity' => $quantity
            ];
        }
        
        Session::put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'cart_count' => count($cart)
        ]);
    }
    
    /**
     * Update product quantity in cart
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:digital_products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $productId = $request->product_id;
        $quantity = $request->quantity;
        
        // Get current cart
        $cart = Session::get('cart', []);
        
        // Update product quantity
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            Session::put('cart', $cart);
            
            // Recalculate cart totals
            $product = DigitalProduct::find($productId);
            $itemTotal = $product->getDiscountedPrice() * $quantity;
            
            return response()->json([
                'success' => true,
                'message' => 'Cart updated',
                'item_total' => $itemTotal,
                'cart_count' => count($cart)
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart'
        ], 404);
    }
    
    /**
     * Remove a product from the cart
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:digital_products,id'
        ]);
        
        $productId = $request->product_id;
        
        // Get current cart
        $cart = Session::get('cart', []);
        
        // Remove product from cart
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
            
            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart',
                'cart_count' => count($cart)
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart'
        ], 404);
    }
    
    /**
     * Apply a coupon code to the cart
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon' => 'required|string|max:50'
        ]);
        
        $couponCode = $request->coupon;
        
        // Here you would typically check if the coupon is valid in your database
        // For this example, we'll just check if the code is "DISCOUNT50"
        if ($couponCode === 'DISCOUNT50') {
            Session::put('discount', 50000); // 50,000 IDR discount
            
            return response()->json([
                'success' => true,
                'message' => 'Coupon applied successfully',
                'discount' => 50000
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Invalid coupon code'
        ], 400);
    }
}