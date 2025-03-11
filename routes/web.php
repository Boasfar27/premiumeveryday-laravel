<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProductManagementController;
use Jenssegers\Agent\Agent;
use App\Http\Controllers\AuthController;

Route::middleware('web')->group(function () {
    // Public Routes
    Route::get('/', function () {
        $agent = new Agent();
        return view($agent->isMobile() ? 'pages.mobile.welcome' : 'pages.desktop.welcome');
    })->name('home');

    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/timeline', [TimelineController::class, 'index'])->name('timeline');
    Route::get('/faq', [FaqController::class, 'index'])->name('faq');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');

    // Authentication Routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [AuthController::class, 'register']);
        Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.redirect');
        Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

        // Password Reset Routes
        Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
        Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
        Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
        Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    });

    // Admin Routes
    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('products', ProductManagementController::class)->names('admin.products');
        Route::post('/users/{user}/toggle-status', [AdminDashboardController::class, 'toggleUserStatus'])->name('admin.users.toggle-status');
    });

    // Authenticated Routes
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        
        // Email Verification Routes
        Route::get('/email/verify', [AuthController::class, 'showVerification'])
            ->name('verification.notice');
        Route::post('/email/verify', [AuthController::class, 'verify'])
            ->name('verification.verify');
        Route::post('/email/resend', [AuthController::class, 'resendVerification'])
            ->name('verification.resend');

        // User Routes
        Route::middleware(['verified'])->prefix('user')->name('user.')->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('/orders', [OrderController::class, 'index'])->name('orders');
            Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        });
    });
});
