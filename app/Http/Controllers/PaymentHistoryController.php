<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\MidtransTransaction;
use Midtrans\Transaction;
use Midtrans\Config;
use Jenssegers\Agent\Agent;

class PaymentHistoryController extends Controller
{
    /**
     * Display the specified payment detail.
     */
    public function show(Order $order)
    {
        // Check if order belongs to current user
        if ($order->user_id != auth()->id()) {
            abort(403, 'You are not authorized to view this order.');
        }
        
        // Check payment status if still pending
        $canRetry = false;
        $canReview = false;
        
        if ($order->payment_status == 'pending' && $order->payment_method == 'midtrans') {
            $midtransTransaction = $order->midtransTransaction;
            
            if ($midtransTransaction && $midtransTransaction->midtrans_order_id) {
                // Configure Midtrans API
                Config::$serverKey = config('midtrans.server_key');
                Config::$isProduction = config('midtrans.is_production');
                
                try {
                    // Get status from Midtrans API
                    $status = Transaction::status($midtransTransaction->midtrans_order_id);
                    
                    if (isset($status->transaction_status)) {
                        // Update status if settlement or expired
                        if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
                            $order->update([
                                'payment_status' => 'paid',
                                'status' => 'approved',
                                'paid_at' => now()
                            ]);
                        } else if (in_array($status->transaction_status, ['deny', 'cancel', 'expire', 'failure'])) {
                            $order->update([
                                'payment_status' => 'failed',
                                'status' => 'rejected'
                            ]);
                        }
                        
                        // Update transaction record with payment type and status
                        $midtransTransaction->update([
                            'transaction_status' => $status->transaction_status,
                            'status_code' => $status->status_code ?? null,
                            'status_message' => $status->status_message ?? null,
                            'payment_type' => $status->payment_type ?? $midtransTransaction->payment_type,
                        ]);
                        
                        // Refresh the order
                        $order = $order->fresh();
                    }
                } catch (\Exception $e) {
                    // Log the error but continue
                    \Log::error('Error checking Midtrans status: ' . $e->getMessage());
                }
            }
        }
        
        // Can retry payment if status is pending, failed, or expired and not too old
        $canRetry = in_array($order->payment_status, ['pending', 'failed', 'expired']) && 
                   $order->created_at->diffInDays(now()) < 7;
        
        // Can review if the order is completed and has products
        $canReview = $order->payment_status == 'paid' && $order->items->count() > 0;
        
        // Check if user has already left a review
        $hasReviewed = $order->reviews()->where('user_id', auth()->id())->exists();
        
        // Get the proper view based on user agent
        $agent = new \Jenssegers\Agent\Agent();
        $view = $agent->isMobile() 
            ? 'pages.mobile.payments.detail' 
            : 'pages.desktop.payments.detail';
            
        return view($view, compact('order', 'canRetry', 'canReview', 'hasReviewed'));
    }
} 