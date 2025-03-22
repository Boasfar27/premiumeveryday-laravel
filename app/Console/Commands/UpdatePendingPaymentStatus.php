<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\MidtransTransaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Midtrans\Transaction;
use Midtrans\Config;

class UpdatePendingPaymentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:update-status {--order_id= : Specific order ID to check} {--all : Check all pending orders}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update payment status for pending orders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ensure Midtrans configuration is set
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        
        $this->info('Starting payment status update process...');
        
        // If specific order ID is provided
        if ($orderId = $this->option('order_id')) {
            $this->info("Checking order ID: {$orderId}");
            $order = Order::find($orderId);
            
            if (!$order) {
                $this->error("Order ID {$orderId} not found.");
                return;
            }
            
            $this->updateOrderStatus($order);
            return;
        }
        
        // Process all pending orders
        if ($this->option('all')) {
            $this->info('Checking all pending orders...');
            $orders = Order::where('payment_status', 'pending')->get();
            
            $this->info("Found {$orders->count()} pending orders.");
            
            foreach ($orders as $order) {
                $this->updateOrderStatus($order);
            }
            
            $this->info('Payment status update completed.');
            return;
        }
        
        // Default: Just check recent pending orders (last 3 days)
        $this->info('Checking recent pending orders (last 3 days)...');
        $recentOrders = Order::where('payment_status', 'pending')
            ->where('created_at', '>=', now()->subDays(3))
            ->get();
            
        $this->info("Found {$recentOrders->count()} recent pending orders.");
        
        foreach ($recentOrders as $order) {
            $this->updateOrderStatus($order);
        }
        
        $this->info('Payment status update completed.');
    }
    
    /**
     * Update the status of a specific order
     */
    private function updateOrderStatus(Order $order)
    {
        $this->info("Processing order #{$order->id} ({$order->order_number})...");
        
        try {
            // Get the most recent Midtrans transaction for this order
            $midtransTransaction = MidtransTransaction::where('order_id', $order->id)
                ->latest()
                ->first();
                
            if (!$midtransTransaction || !$midtransTransaction->midtrans_order_id) {
                $this->warn("No Midtrans transaction found for order #{$order->id}.");
                return;
            }
            
            // Get status from Midtrans API
            $status = Transaction::status($midtransTransaction->midtrans_order_id);
            
            if (isset($status->transaction_status)) {
                $transactionStatus = $status->transaction_status;
                
                $this->info("Order #{$order->id}: Midtrans status is '{$transactionStatus}'");
                
                // Update the order status based on transaction status
                switch ($transactionStatus) {
                    case 'settlement':
                    case 'capture':
                        $order->update([
                            'payment_status' => 'paid',
                            'status' => 'approved',
                            'paid_at' => now()
                        ]);
                        $this->info("Order #{$order->id}: Marked as PAID.");
                        break;
                        
                    case 'pending':
                        $order->update([
                            'payment_status' => 'pending',
                            'status' => 'pending'
                        ]);
                        $this->info("Order #{$order->id}: Confirmed as PENDING.");
                        break;
                        
                    case 'deny':
                    case 'cancel':
                    case 'expire':
                    case 'failure':
                        $order->update([
                            'payment_status' => 'failed',
                            'status' => 'failed'
                        ]);
                        $this->info("Order #{$order->id}: Marked as FAILED ({$transactionStatus}).");
                        break;
                        
                    default:
                        $this->info("Order #{$order->id}: Unknown status '{$transactionStatus}', no change.");
                        break;
                }
                
                // Update transaction record
                MidtransTransaction::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'transaction_id' => $status->transaction_id ?? null,
                        'payment_type' => $status->payment_type ?? null,
                        'transaction_time' => $status->transaction_time ?? null,
                        'transaction_status' => $transactionStatus,
                        'status_code' => $status->status_code ?? null,
                        'status_message' => $status->status_message ?? null,
                    ]
                );
            } else {
                $this->warn("Order #{$order->id}: No transaction status available from Midtrans.");
            }
        } catch (\Exception $e) {
            $this->error("Error checking status for order #{$order->id}: " . $e->getMessage());
            Log::error("Error in UpdatePendingPaymentStatus for order #{$order->id}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
