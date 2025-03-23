<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DigitalProductController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use Jenssegers\Agent\Agent;
use App\Models\DigitalProduct;
use App\Models\Timeline;
use App\Models\Faq;
use App\Models\Contact;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\PaymentHistoryController;
use App\Http\Controllers\MidtransController;
use Illuminate\Http\Request;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Order;
use App\Models\UserSubscription;
use App\Http\Controllers\User\OrderReviewController;
use App\Http\Controllers\ReviewController;
use App\Models\Review;
use App\Http\Controllers\LicenseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    $agent = new Agent();
    
    // Get featured products with categories
    $featuredProducts = DigitalProduct::with('category')
        ->where('is_active', true)
        ->where('is_featured', true)
        ->orderBy('sort_order')
        ->take(3)
        ->get();
    
    // Get latest products
    $latestProducts = DigitalProduct::with('category')
        ->where('is_active', true)
        ->latest()
        ->take(8)
        ->get();
    
    // Get products by category
    $streamingVideoProducts = DigitalProduct::whereHas('category', function($query) {
        $query->where('slug', 'streaming-video');
    })->where('is_active', true)->take(4)->get();
    
    $streamingMusicProducts = DigitalProduct::whereHas('category', function($query) {
        $query->where('slug', 'streaming-music');
    })->where('is_active', true)->take(4)->get();
    
    // Get timelines
    $timelines = Timeline::where('is_active', true)
        ->orderBy('order')
        ->take(3)
        ->get();
    
    // Get FAQs by category
    $generalFaqs = Faq::where('category', 'general')
        ->where('is_active', true)
        ->orderBy('order')
        ->take(3)
        ->get();
        
    $streamingFaqs = Faq::whereIn('category', ['streaming-video', 'streaming-music'])
        ->where('is_active', true)
        ->orderBy('order')
        ->take(3)
        ->get();
    
    // Get contacts
    $contacts = Contact::where('is_active', true)
        ->orderBy('order')
        ->get();
        
    // Get testimonials/reviews 
    $testimonials = \App\Models\Review::where('is_active', true)
        ->where('rating', '>=', 4)
        ->latest()
        ->take(12)
        ->get();
    
    return view(
        $agent->isMobile() ? 'pages.mobile.home' : 'pages.desktop.home',
        compact(
            'featuredProducts', 
            'latestProducts',
            'streamingVideoProducts',
            'streamingMusicProducts',
            'timelines', 
            'generalFaqs',
            'streamingFaqs',
            'contacts',
            'testimonials'
        )
    );
})->name('home');

// Public Product Routes
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [DigitalProductController::class, 'index'])->name('index');
    Route::get('/streaming-video', [DigitalProductController::class, 'streamingVideo'])->name('streaming-video');
    Route::get('/streaming-music', [DigitalProductController::class, 'streamingMusic'])->name('streaming-music');
    Route::get('/productivity-tools', [DigitalProductController::class, 'productivityTools'])->name('productivity-tools');
    Route::get('/premium-software', [DigitalProductController::class, 'premiumSoftware'])->name('premium-software');
    Route::get('/{product}', [DigitalProductController::class, 'show'])->name('show');
});

// Categories Routes
Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
});

// Public Information Routes
Route::get('/timeline', [TimelineController::class, 'index'])->name('timeline');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register Routes
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Google OAuth Routes
    Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

    // Password Reset Routes
    Route::get('/forgot-password', function () {
        $agent = new Agent();
        return view($agent->isMobile() ? 'pages.auth.mobile.forgot-password' : 'pages.auth.desktop.forgot-password');
    })->name('password.request');
    
    Route::post('/forgot-password', [\App\Http\Controllers\Auth\AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', function ($token) {
        $agent = new Agent();
        return view($agent->isMobile() ? 'pages.auth.mobile.reset-password' : 'pages.auth.desktop.reset-password', ['token' => $token]);
    })->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\Auth\AuthController::class, 'resetPassword'])->name('password.update');
});

// Protected Routes
Route::middleware('auth')->group(function () {
    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Email Verification Routes
    Route::prefix('email')->name('verification.')->group(function () {
        Route::get('/verify', [AuthController::class, 'showVerification'])->name('notice');
        Route::get('/verify/{code}', [AuthController::class, 'verify'])->name('verify');
        Route::post('/resend', [AuthController::class, 'resendVerification'])
            ->name('resend')
            ->middleware(['throttle:6,1']);
    });

    // User Routes
    Route::middleware(['verified'])->prefix('user')->name('user.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        
        // Profile Routes
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        
        // User Orders -> ganti dengan Payment History
        Route::prefix('payments')->middleware(['auth', 'verified'])->name('payments.')->group(function () {
            Route::get('/', [PaymentHistoryController::class, 'index'])->name('history');
            Route::get('/{order}', [PaymentHistoryController::class, 'show'])->name('detail');
            Route::post('/', [PaymentHistoryController::class, 'store'])->name('store');
        });

        // Apply Coupon
        Route::post('/coupons/apply', [CouponController::class, 'apply'])->name('coupons.apply');

        // Review Routes
        Route::prefix('payments/{order}/review')->name('payments.review.')->group(function () {
            Route::get('/create', [OrderReviewController::class, 'create'])->name('create');
            Route::post('/', [OrderReviewController::class, 'store'])->name('store');
            Route::get('/{review}/edit', [OrderReviewController::class, 'edit'])->name('edit');
            Route::put('/{review}', [OrderReviewController::class, 'update'])->name('update');
            Route::delete('/{review}', [OrderReviewController::class, 'destroy'])->name('destroy');
        });
    });

    // Notification Routes
    Route::prefix('notifications')->name('notifications.')->middleware(['auth'])->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('markAllAsRead');
    });
    
    // Admin Dashboard Route
    Route::get('/admin/dashboard', function () {
        return redirect('/admin');
    })->name('admin.dashboard');
});

// Legal Routes
Route::prefix('legal')->name('legal.')->group(function () {
    Route::get('/terms', function () {
        return view('pages.legal.terms');
    })->name('terms');
    
    Route::get('/privacy', function () {
        return view('pages.legal.privacy');
    })->name('privacy');
});

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->middleware('auth')->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->middleware('auth')->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->middleware('auth')->name('cart.remove');
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->middleware('auth')->name('cart.apply-coupon');
Route::post('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.remove-coupon');

// Checkout and Payment Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/process-payment', [CartController::class, 'processPayment'])->name('process.payment');
});

// Main routes file with updated Midtrans callback paths

// Add these routes OUTSIDE the payment prefix for direct access
Route::get('/payment/midtrans/finish', [MidtransController::class, 'finish'])->name('payment.midtrans.finish');

Route::get('/payment/midtrans/unfinish', function(Request $request) {
    // Extract order number from the order_id parameter (format: ORD-123456789-1)
    $orderNumber = $request->input('order_id');
    if ($orderNumber) {
        // Find the order by order_number
        $order = \App\Models\Order::where('order_number', $orderNumber)->first();
        if ($order) {
            // Update order status
            $order->update([
                'payment_status' => 'pending'
            ]);
            
            // Redirect to order details page with info message
            return redirect()->route('user.payments.detail', $order)
                ->with('info', 'Payment is pending. Please complete your payment to proceed.');
        }
    }
    
    // Default fallback if order not found
    return redirect()->route('user.payments.history')
        ->with('info', 'Payment is pending. Please check your payments to complete payment.');
})->name('payment.midtrans.unfinish');

Route::get('/payment/midtrans/error', function(Request $request) {
    // Extract order number from the order_id parameter (format: ORD-123456789-1)
    $orderNumber = $request->input('order_id');
    if ($orderNumber) {
        // Find the order by order_number
        $order = \App\Models\Order::where('order_number', $orderNumber)->first();
        if ($order) {
            // Update order status
            $order->update([
                'payment_status' => 'failed'
            ]);
            
            // Redirect to order details page with error message
            return redirect()->route('user.payments.detail', $order)
                ->with('error', 'Payment failed. Please try again or contact support if the issue persists.');
        }
    }
    
    // Default fallback if order not found
    return redirect()->route('user.payments.history')
        ->with('error', 'Payment failed. Please try again or contact support.');
})->name('payment.midtrans.error');

// Keep the payment prefix routes for other midtrans functionality
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/midtrans/{order}', [MidtransController::class, 'paymentPage'])->name('midtrans.page');
    Route::post('/midtrans/notification', [MidtransController::class, 'handleNotification'])->name('midtrans.notification');
    Route::get('/midtrans/status/{order}', [MidtransController::class, 'checkStatus'])->name('midtrans.status');
    Route::get('/midtrans/redirect/{order}', [MidtransController::class, 'redirectToVTWeb'])->name('midtrans.redirect');
});

Route::get('/debug-images', function () {
    $categories = \App\Models\Category::all();
    $products = \App\Models\DigitalProduct::all();
    
    return view('debug-images', compact('categories', 'products'));
});

Route::get('/test-images', function () {
    return view('test-images');
});

// Midtrans payment routes
Route::prefix('payment/midtrans')->name('payment.midtrans.')->group(function () {
    Route::get('/page/{order}', [MidtransController::class, 'paymentPage'])->name('page');
    Route::get('/check-status/{order}', [MidtransController::class, 'checkStatus'])->name('check_status');
    Route::get('/finish', [MidtransController::class, 'finish'])->name('finish');
    Route::get('/unfinish', [MidtransController::class, 'unfinish'])->name('unfinish');
    Route::get('/error', [MidtransController::class, 'error'])->name('error');
    Route::get('/redirect/{order}', [MidtransController::class, 'redirectToVTWeb'])->name('redirect');
});

// Midtrans notification webhook - Make sure this URL matches what's configured in Midtrans dashboard
Route::post('/payment/midtrans/notification', [MidtransController::class, 'handleNotification'])->name('payment.midtrans.notification');
// Add a GET fallback for testing
Route::get('/payment/midtrans/notification', [MidtransController::class, 'handleNotification'])->name('payment.midtrans.notification.get');

// Debug routes
Route::prefix('debug')->name('debug.')->middleware(['auth'])->group(function () {
    Route::get('/images', [App\Http\Controllers\DebugController::class, 'images'])->name('images');
    Route::post('/fix-images', [App\Http\Controllers\DebugController::class, 'fixImages'])->name('fix-images');
});

// License routes
Route::prefix('licenses')->middleware(['auth'])->group(function () {
    Route::get('/', [LicenseController::class, 'index'])->name('licenses.index');
    Route::get('/{license}', [LicenseController::class, 'show'])->name('licenses.show');
    Route::get('/{license}/activate', [LicenseController::class, 'activate'])->name('licenses.activate');
    Route::post('/{license}/activate', [LicenseController::class, 'processActivation'])->name('licenses.process-activation');
    Route::get('/{license}/success-activation', [LicenseController::class, 'showSuccessActivation'])->name('licenses.success-activation');
    
    // Add PDF export route
    Route::post('/export', [LicenseController::class, 'exportPdf'])->name('licenses.export');
});

// Midtrans Payment Routes
Route::prefix('payment/midtrans')->group(function () {
    Route::get('page/{order}', [MidtransController::class, 'paymentPage'])->name('payment.midtrans.page');
    Route::get('finish', [MidtransController::class, 'finish'])->name('payment.midtrans.finish');
    Route::get('unfinish', function () {
        return redirect()->route('user.payments.history')->with('info', 'Payment is pending. Please complete your payment.');
    })->name('payment.midtrans.unfinish');
    Route::get('error', function () {
        return redirect()->route('user.payments.history')->with('error', 'Payment failed. Please try again or contact support.');
    })->name('payment.midtrans.error');
    Route::post('notification', [MidtransController::class, 'handleNotification'])->name('payment.midtrans.notification');
    
    // Tambahkan route untuk force update status
    Route::get('force-update/{order}', function (App\Models\Order $order) {
        // Log aktivitas ini
        \Illuminate\Support\Facades\Log::info('Force update status for order', [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'current_status' => $order->payment_status
        ]);
        
        // Update order status
        $order->update([
            'payment_status' => 'paid',
            'status' => 'approved',
            'paid_at' => now()
        ]);
        
        // Update MidtransTransaction jika ada
        $midtransTransaction = App\Models\MidtransTransaction::where('order_id', $order->id)->first();
        if ($midtransTransaction) {
            $midtransTransaction->update([
                'transaction_status' => 'settlement',
                'status_message' => 'Transaction has been manually updated'
            ]);
        }
        
        return redirect()->route('user.payments.detail', $order)
            ->with('success', 'Status pembayaran berhasil diperbarui menjadi PAID');
    })->name('payment.midtrans.force-update')->middleware(['auth']);
});
    