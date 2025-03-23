<?php

namespace App\Http\Controllers;

use App\Models\DigitalProduct;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

class CartController extends Controller
{
    /**
     * Display the cart page
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $products = [];
        $subtotal = 0;
        $discount = 0;
        
        foreach ($cart as $id => $details) {
            $product = DigitalProduct::find($id);
            if ($product) {
                $itemPrice = $details['price'] ?? $product->getDiscountedPrice();
                $itemQuantity = $details['quantity'] ?? 1;
                $itemTotal = $itemPrice * $itemQuantity;
                
                $products[] = [
                    'id' => $id,
                    'product' => $product,
                    'quantity' => $itemQuantity,
                    'price' => $itemPrice,
                    'subscription_type' => $details['subscription_type'] ?? 'monthly',
                    'duration' => $details['duration'] ?? 1,
                    'account_type' => $details['account_type'] ?? 'sharing',
                    'total' => $itemTotal
                ];
                
                $subtotal += $itemTotal;
            }
        }

        // Get discount from coupon if exists
        if (session()->has('coupon')) {
            $couponData = session('coupon');
            $discount = $couponData['discount'] ?? 0;
            
            // Apply discount to individual products if needed
            if ($discount > 0 && count($products) > 0) {
                foreach ($products as &$item) {
                    $itemDiscount = $discount / count($products);
                    $item['discounted_price'] = max(0, $item['price'] - $itemDiscount);
                }
            }
        }

        $taxRate = Setting::get('tax_rate', 5) / 100;
        $tax = ($subtotal - $discount) * $taxRate;
        $total = $subtotal - $discount + $tax;
        
        $recentProducts = Product::latest()->take(4)->get();

        return view('pages.' . (request()->is('mobile/*') ? 'mobile' : 'desktop') . '.cart.index', compact(
            'products',
            'subtotal',
            'discount',
            'tax',
            'total',
            'recentProducts'
        ));
    }
    
    /**
     * Add a product to the cart
     */
    public function add(Request $request)
    {
        try {
            // Check if user is authenticated
            if (!auth()->check()) {
                if ($request->ajax() || $request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Please login to purchase products'
                    ], 401);
                }
                
                return redirect()->route('login')
                    ->with('error', 'Please login to purchase products')
                    ->with('redirect', url()->previous());
            }
            
            $validated = $request->validate([
                'product_id' => 'required|exists:digital_products,id',
                'quantity' => 'required|integer|min:1',
                'subscription_type' => 'required|in:monthly,quarterly,semiannual,annual',
                'duration' => 'required|integer|min:1',
                'account_type' => 'nullable|in:sharing,private'
            ]);
            
            $productId = $validated['product_id'];
            $quantity = $validated['quantity'];
            $subscriptionType = $validated['subscription_type'];
            $duration = $validated['duration'];
            $accountType = $validated['account_type'] ?? 'sharing';
            
            $product = DigitalProduct::findOrFail($productId);
            
            // Calculate price based on subscription type, duration, and account type
            if ($accountType == 'private') {
                // For private account, use private_price if available or multiply regular price by 1.5
                $basePrice = $product->private_price ?? ($product->price * 1.5);
                
                // Apply promo discount for private price if applicable
                if ($product->is_promo && $product->promo_ends_at > now() && ($product->private_discount ?? 0) > 0) {
                    $basePrice = $basePrice - ($basePrice * ($product->private_discount ?? 0) / 100);
                }
            } else {
                // For sharing account, use normal price with any sale price
                $basePrice = $product->getDiscountedPrice();
            }
            
            $totalPrice = $basePrice * $duration;
            
            // Apply discount based on subscription duration
            if ($subscriptionType == 'quarterly') {
                $totalPrice = $basePrice * $duration * 0.9; // 10% discount
            } elseif ($subscriptionType == 'semiannual') {
                $totalPrice = $basePrice * $duration * 0.8; // 20% discount
            } elseif ($subscriptionType == 'annual') {
                $totalPrice = $basePrice * $duration * 0.7; // 30% discount
            }
            
            // Get cart from session
            $cart = Session::get('cart', []);
            
            // Check if product already exists in cart
            if (isset($cart[$productId])) {
                // Update quantity and subscription details
                $cart[$productId]['quantity'] = $quantity;
                $cart[$productId]['subscription_type'] = $subscriptionType;
                $cart[$productId]['duration'] = $duration;
                $cart[$productId]['account_type'] = $accountType;
                $cart[$productId]['price'] = $totalPrice;
            } else {
                // Add new product to cart
                $cart[$productId] = [
                    'quantity' => $quantity,
                    'subscription_type' => $subscriptionType,
                    'duration' => $duration,
                    'account_type' => $accountType,
                    'price' => $totalPrice
                ];
            }
            
            Session::put('cart', $cart);
            
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product added to cart',
                    'cart_count' => count($cart)
                ]);
            }
            
            return redirect()->route('cart.index')->with('success', 'Product added to cart');
        } catch (\Exception $e) {
            Log::error('Error adding to cart: ' . $e->getMessage());
            
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add product to cart: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Failed to add product to cart');
        }
    }
    
    /**
     * Update product quantity in cart
     */
    public function update(Request $request)
    {
        try {
            Log::info('Cart update request', $request->all());
            
            $validated = $request->validate([
            'product_id' => 'required|exists:digital_products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
            $productId = $validated['product_id'];
            $quantity = $validated['quantity'];
        
        // Get current cart
        $cart = Session::get('cart', []);
        
            // Check if product exists in cart
            if (!isset($cart[$productId])) {
                if ($request->ajax() || $request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Product not found in cart'
                    ], 404);
                }
                
                return redirect()->back()->with('error', 'Product not found in cart');
            }
            
            // Handle cart_action for form submissions
            // If increment/decrement action is present, adjust the quantity
            if ($request->has('cart_action')) {
                $action = $request->input('cart_action');
                
                if ($action === 'increment') {
                    $quantity = $cart[$productId]['quantity'] + 1;
                } elseif ($action === 'decrement' && $cart[$productId]['quantity'] > 1) {
                    $quantity = $cart[$productId]['quantity'] - 1;
                }
            }
            
            // Preserve existing subscription info
            $subscriptionType = $cart[$productId]['subscription_type'] ?? 'monthly';
            $duration = $cart[$productId]['duration'] ?? 1;
            $price = $cart[$productId]['price'] ?? null;
            
            // If price is not set, calculate it
            if ($price === null) {
                $product = DigitalProduct::find($productId);
                if (!$product) {
                    if ($request->ajax() || $request->expectsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Product not found'
                        ], 404);
                    }
                    
                    return redirect()->back()->with('error', 'Product not found');
                }
                
                $basePrice = $product->getDiscountedPrice();
                
                // Apply discount based on subscription type
                if ($subscriptionType == 'quarterly') {
                    $price = $basePrice * $duration * 0.9; // 10% discount
                } elseif ($subscriptionType == 'semiannual') {
                    $price = $basePrice * $duration * 0.8; // 20% discount
                } elseif ($subscriptionType == 'annual') {
                    $price = $basePrice * $duration * 0.7; // 30% discount
                } else {
                    $price = $basePrice * $duration;
                }
            }
            
            // Update cart
            $cart[$productId]['quantity'] = $quantity;
            Session::put('cart', $cart);
            
            // Calculate new item total
            $itemTotal = $price * $quantity;
            
            // Calculate new cart totals
            $subtotal = 0;
            foreach ($cart as $id => $item) {
                $itemPrice = $item['price'] ?? 0;
                $itemQuantity = $item['quantity'] ?? 0;
                $subtotal += $itemPrice * $itemQuantity;
            }
            
            $discount = Session::get('discount', 0);
            $taxRate = Setting::get('tax_rate', 5) / 100;
            $tax = ($subtotal - $discount) * $taxRate;
            $total = $subtotal - $discount + $tax;
            
            if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                    'message' => 'Cart updated successfully',
                'item_total' => $itemTotal,
                    'cart_count' => count($cart),
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'tax' => $tax,
                    'total' => $total
                ]);
            }
            
            return redirect()->route('cart.index')->with('success', 'Cart updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating cart: ' . $e->getMessage());
            
            if ($request->ajax() || $request->expectsJson()) {
        return response()->json([
            'success' => false,
                    'message' => 'Failed to update cart: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Failed to update cart: ' . $e->getMessage());
        }
    }
    
    /**
     * Remove a product from the cart
     */
    public function remove(Request $request)
    {
        try {
            Log::info('Cart remove request', $request->all());
            
            $validated = $request->validate([
            'product_id' => 'required|exists:digital_products,id'
        ]);
        
            $productId = $validated['product_id'];
        
        // Get current cart
        $cart = Session::get('cart', []);
        
        // Remove product from cart
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
            
                // Recalculate totals
                $subtotal = 0;
                foreach ($cart as $id => $item) {
                    $itemPrice = $item['price'] ?? 0;
                    $itemQuantity = $item['quantity'] ?? 0;
                    $subtotal += $itemPrice * $itemQuantity;
                }
                
                $discount = Session::get('discount', 0);
                $taxRate = Setting::get('tax_rate', 5) / 100;
                $tax = ($subtotal - $discount) * $taxRate;
                $total = $subtotal - $discount + $tax;
                
                if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart',
                        'cart_count' => count($cart),
                        'subtotal' => $subtotal,
                        'discount' => $discount,
                        'tax' => $tax,
                        'total' => $total
                    ]);
                }
                
                return redirect()->route('cart.index')->with('success', 'Product removed from cart');
            }
            
            if ($request->ajax() || $request->expectsJson()) {
        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart'
        ], 404);
            }
            
            return redirect()->route('cart.index')->with('error', 'Product not found in cart');
        } catch (\Exception $e) {
            Log::error('Error removing from cart: ' . $e->getMessage());
            
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to remove item: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Failed to remove item: ' . $e->getMessage());
        }
    }
    
    /**
     * Apply coupon to cart
     */
    public function applyCoupon(Request $request)
    {
        try {
            $code = $request->input('coupon_code');

            // Cari kupon berdasarkan kode
            $coupon = Coupon::where('code', $code)
                ->where('is_active', true)
                ->first();

            if (!$coupon) {
                return redirect()->back()->with('error', 'Coupon code is not valid!');
            }

            // Verifikasi tanggal berlaku kupon
            $now = now();
            if ($coupon->start_date && $now < $coupon->start_date) {
                return redirect()->back()->with('error', 'Coupon is not active yet!');
            }

            if ($coupon->end_date && $now > $coupon->end_date) {
                return redirect()->back()->with('error', 'Coupon has expired!');
            }

            // Verifikasi batas penggunaan kupon
            if ($coupon->max_uses && $coupon->used_count >= $coupon->max_uses) {
                return redirect()->back()->with('error', 'Coupon has reached its usage limit!');
            }

            // Mendapatkan subtotal dari keranjang
            $cart = Session::get('cart', []);
            $subtotal = 0;

            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            // Periksa pembelian minimum jika ada
            if ($coupon->min_purchase && $subtotal < $coupon->min_purchase) {
                return redirect()->back()->with('error', 'Minimum purchase requirement not met!');
            }

            // Hitung diskon berdasarkan tipe kupon
            $discount = $coupon->calculateDiscount($subtotal);

            // Tambahkan kupon ke sesi
            Session::put('coupon', [
                'code' => $coupon->code,
                'discount' => $discount,
                'coupon_id' => $coupon->id
            ]);

            // Log untuk debugging
            \Log::info('Coupon applied', [
                'code' => $coupon->code,
                'discount_value' => $coupon->getDiscountValue(),
                'type' => $coupon->type,
                'subtotal' => $subtotal,
                'calculated_discount' => $discount
            ]);

            return redirect()->back()->with('success', 'Coupon applied successfully!');
        } catch (\Exception $e) {
            \Log::error('Error applying coupon: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error applying coupon!');
        }
    }

    /**
     * Remove coupon from cart
     */
    public function removeCoupon()
    {
        Session::forget(['coupon']);
        
        if (request()->ajax() || request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Coupon has been removed successfully.'
            ]);
        }
        
        return redirect()->route('cart.index')->with('success', 'Coupon has been removed successfully.');
    }

    /**
     * Proceed to checkout
     */
    public function checkout()
    {
        // Check if cart is empty
        $cart = Session::get('cart', []);
        if (count($cart) === 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Please add products before checkout.');
        }
        
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
                    'subscription_type' => $item['subscription_type'] ?? 'monthly',
                    'duration' => $item['duration'] ?? 1,
                    'account_type' => $item['account_type'] ?? 'sharing',
                    'price' => $item['price'] ?? $product->getDiscountedPrice(),
                    'total' => ($item['price'] ?? $product->getDiscountedPrice()) * $item['quantity']
                ];
                $subtotal += ($item['price'] ?? $product->getDiscountedPrice()) * $item['quantity'];
            }
        }
        
        // Calculate discount only if coupon exists
        $discount = 0;
        $couponCode = null;
        if (Session::has('coupon')) {
            $couponData = Session::get('coupon');
            $discount = $couponData['discount'] ?? 0;
            $couponCode = $couponData['code'] ?? null;
        }
        
        // Calculate tax and total
        $taxRate = Setting::get('tax_rate', 5) / 100;
        $tax = ($subtotal - $discount) * $taxRate;
        $total = $subtotal - $discount + $tax;
        
        // Generate unique order number
        $orderNumber = 'ORD-' . time() . '-' . auth()->id();
        
        // Store order information in session for payment page
        Session::put('checkout', [
            'order_number' => $orderNumber,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'total' => $total,
            'products' => $products,
            'coupon_code' => $couponCode,
            'created_at' => now()->format('Y-m-d H:i:s')
        ]);
        
        // Determine if desktop or mobile view
        $agent = new \Jenssegers\Agent\Agent();
        $view = $agent->isMobile() ? 'pages.mobile.checkout.index' : 'pages.desktop.checkout.index';
        
        return view($view, compact('products', 'subtotal', 'discount', 'tax', 'total', 'orderNumber'));
    }

    /**
     * Process payment with Midtrans
     */
    public function processPayment(Request $request)
    {
        // Validate the request
        $request->validate([
            'terms' => 'required|accepted'
        ]);
        
        // Get checkout information from session
        $checkout = Session::get('checkout');
        if (!$checkout) {
            return redirect()->route('cart.index')
                ->with('error', 'Checkout information not found. Please try again.');
        }
        
        // List all available payment methods for Midtrans
        $paymentMethods = ['mandiri_va', 'bni_va', 'bri_va', 'cimb_va', 'gopay', 'permata_va', 'other_va', 'qris'];
        
        // Manually insert to orders table to avoid model validation issues
        $orderId = DB::table('orders')->insertGetId([
            'user_id' => auth()->id(),
            'order_number' => $checkout['order_number'],
            'subtotal' => $checkout['subtotal'],
            'tax' => $checkout['tax'],
            'discount_amount' => $checkout['discount'],
            'total' => $checkout['total'],
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_methods' => json_encode($paymentMethods),
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'whatsapp' => auth()->user()->phone ?? '',
            'product_name' => count($checkout['products']) > 0 ? $checkout['products'][0]['product']->name : 'Unknown Product',
            'subscription_type' => count($checkout['products']) > 0 ? $checkout['products'][0]['duration'] : 'monthly',
            'amount' => $checkout['subtotal'],
            'final_amount' => $checkout['total'],
            'coupon_code' => $checkout['coupon_code'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Get the order model instance
        $order = \App\Models\Order::findOrFail($orderId);
        
        // Create order items
        foreach ($checkout['products'] as $item) {
            $order->items()->create([
                'orderable_id' => $item['product']->id,
                'orderable_type' => get_class($item['product']),
                'name' => $item['product']->name,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'unit_price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
                'total' => $item['price'] * $item['quantity'],
                'subscription_type' => $item['subscription_type'],
                'duration' => $item['duration'],
                'account_type' => $item['account_type'] ?? 'sharing'
            ]);
        }
        
        // Send notification to admin about new order
        app(NotificationService::class)->notifyAdminAboutNewOrder($order);
        
        // Clear cart and checkout session
        Session::forget(['cart', 'checkout', 'discount', 'applied_coupon']);
        
        // Redirect to Midtrans payment page
        return redirect()->route('payment.midtrans.page', $order);
    }
}