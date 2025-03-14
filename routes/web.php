<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProductManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\User\ProfileController;
use Jenssegers\Agent\Agent;
use App\Models\Product;
use App\Models\Timeline;
use App\Models\Faq;
use App\Models\Contact;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\NotificationManagementController;

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
        ->take(6)
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

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/timeline', [TimelineController::class, 'index'])->name('timeline');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

    // Password Reset Routes
    Route::get('/forgot-password', function () {
        $agent = new Agent();
        return view($agent->isMobile() ? 'pages.auth.mobile.forgot-password' : 'pages.auth.desktop.forgot-password');
    })->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
        ->name('password.email');
    Route::get('/reset-password/{token}', function ($token) {
        $agent = new Agent();
        return view($agent->isMobile() ? 'pages.auth.mobile.reset-password' : 'pages.auth.desktop.reset-password', ['token' => $token]);
    })->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->name('password.update');
});

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Email Verification Routes
    Route::get('/email/verify', [AuthController::class, 'showVerification'])
        ->name('verification.notice');
    
    Route::get('/email/verify/{code}', [AuthController::class, 'verify'])
        ->name('verification.verify');
    
    Route::post('/email/resend', [AuthController::class, 'resendVerification'])
        ->name('verification.resend')
        ->middleware(['throttle:6,1']);

    // User Routes
    Route::middleware(['verified'])->prefix('user')->name('user.')->group(function () {
        
        // Profile Routes
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        
        // Orders
        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    });

    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});

// Admin Routes
Route::middleware(['verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductManagementController::class);
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('users.show');
    Route::post('/users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])
        ->name('users.toggle-status');
    Route::post('/users/{user}/toggle-role', [UserManagementController::class, 'toggleRole'])
        ->name('users.toggle-role');
    Route::resource('notifications', NotificationManagementController::class);
});

// Terms and Privacy Routes
Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');
