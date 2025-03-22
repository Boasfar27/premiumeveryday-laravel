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
        // Check if this is the current user's order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if the payment is pending and should be rechecked
        if ($order->payment_status == 'pending' && $order->payment_method == 'midtrans') {
            try {
                // First check if there's a Midtrans transaction
                $midtransTransaction = MidtransTransaction::where('order_id', $order->id)
                    ->latest()
                    ->first();
                
                if ($midtransTransaction && $midtransTransaction->midtrans_order_id) {
                    // Configure Midtrans API
                    Config::$serverKey = config('midtrans.server_key');
                    Config::$isProduction = config('midtrans.is_production');
                    
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
                                'status' => 'failed'
                            ]);
                        }
                        
                        // Update transaction record
                        $midtransTransaction->update([
                            'transaction_status' => $status->transaction_status,
                            'status_code' => $status->status_code ?? null,
                            'status_message' => $status->status_message ?? null,
                        ]);
                        
                        // Refresh the order
                        $order = $order->fresh();
                    }
                }
            } catch (\Exception $e) {
                // Just log the error, but continue showing the page
                \Log::error('Error checking Midtrans status in payment details', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        // Determine if the user can retry payment
        $canRetryPayment = in_array($order->payment_status, ['pending', 'failed']);
        
        // Determine if the user can leave a review
        $canLeaveReview = $order->payment_status == 'paid';
        
        $agent = new Agent();
        $view = $agent->isMobile() ? 'pages.mobile.payments.detail' : 'pages.desktop.payments.detail';
        
        return view($view, [
            'order' => $order,
            'canRetryPayment' => $canRetryPayment,
            'canLeaveReview' => $canLeaveReview
        ]);
    }
} 