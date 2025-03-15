<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use Jenssegers\Agent\Agent;
use App\Models\Product;
use App\Models\Timeline;
use App\Models\Faq;
use App\Models\Contact;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FeedbackController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    $agent = new Agent();
    
    // Get featured products
    $featuredProducts = Product::where('is_active', true)
        ->orderBy('order')
        ->take(3)
        ->get();
    
    // Get timelines
    $timelines = Timeline::where('is_active', true)
        ->orderBy('order')
        ->get();
    
    // Get FAQs
    $faqs = Faq::where('is_active', true)
        ->orderBy('order')
        ->get();
    
    // Get contacts
    $contacts = Contact::where('is_active', true)
        ->orderBy('order')
        ->get();
    
    return view(
        $agent->isMobile() ? 'pages.mobile.home' : 'pages.desktop.home',
        compact('featuredProducts', 'timelines', 'faqs', 'contacts')
    );
})->name('home');

// Public Product Routes
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/{product}', [ProductController::class, 'show'])->name('show');
});

// Public Information Routes
Route::get('/timeline', [TimelineController::class, 'index'])->name('timeline');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Feedback Routes
Route::prefix('feedback')->name('feedback.')->group(function () {
    Route::get('/', [FeedbackController::class, 'index'])->name('index');
    Route::post('/', [FeedbackController::class, 'store'])->name('store');
});

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
    
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', function ($token) {
        $agent = new Agent();
        return view($agent->isMobile() ? 'pages.auth.mobile.reset-password' : 'pages.auth.desktop.reset-password', ['token' => $token]);
    })->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
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
        // Profile Routes
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        
        // User Orders
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/{order}', [OrderController::class, 'show'])->name('show');
            Route::post('/', [OrderController::class, 'store'])->name('store');
        });
    });

    // Notification Routes
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('markAsRead');
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('markAllAsRead');
    });

    // Admin Routes
    Route::middleware(['verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // User Management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('index');
            Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
            Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('delete');
        });
        
        // Product Management
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [AdminProductController::class, 'index'])->name('index');
            Route::get('/create', [AdminProductController::class, 'create'])->name('create');
            Route::post('/', [AdminProductController::class, 'store'])->name('store');
            Route::get('/{product}/edit', [AdminProductController::class, 'edit'])->name('edit');
            Route::put('/{product}', [AdminProductController::class, 'update'])->name('update');
            Route::delete('/{product}', [AdminProductController::class, 'destroy'])->name('delete');
        });
        
        // Order Management
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [AdminOrderController::class, 'index'])->name('index');
            Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
            Route::put('/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('status');
        });
    });
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
