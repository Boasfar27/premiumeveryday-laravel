<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Check Order Exists
Route::get('/check-order/{order}', function($order) {
    $orderModel = Order::find($order);
    if (!$orderModel) {
        return response()->json(['exists' => false]);
    }
    
    // Pengguna tidak perlu login untuk memeriksa keberadaan order
    // tapi kami tetap membatasi informasi yang dikembalikan
    return response()->json(['exists' => true]);
}); 