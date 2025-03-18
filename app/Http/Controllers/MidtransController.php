<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\MidtransTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Snap;
use Midtrans\Transaction;
use Midtrans\Notification;
use Midtrans\Config;
use Jenssegers\Agent\Agent;

class MidtransController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
        
        // Log configuration for debugging
        Log::info('Midtrans Config', [
            'serverKey' => !empty(Config::$serverKey) ? 'Set' : 'Empty',
            'clientKey' => !empty(Config::$clientKey) ? 'Set' : 'Empty',
            'isProduction' => Config::$isProduction,
        ]);
    }

    /**
     * Create Snap Token and redirect URL for Midtrans payment
     */
    public function getSnapToken(Order $order)
    {
        try {
            // Ensure Midtrans configuration is set
            Config::$serverKey = config('midtrans.server_key');
            Config::$clientKey = config('midtrans.client_key');
            Config::$isProduction = config('midtrans.is_production');
            
            // Log configuration for debugging
            Log::info('Midtrans Config in getSnapToken', [
                'serverKey' => !empty(Config::$serverKey) ? 'Set ('.substr(Config::$serverKey, 0, 5).'...)' : 'Empty',
                'clientKey' => !empty(Config::$clientKey) ? 'Set ('.substr(Config::$clientKey, 0, 5).'...)' : 'Empty', 
                'isProduction' => Config::$isProduction,
                'order_number' => $order->order_number,
                'total' => $order->total
            ]);
            
            $items = [];
            
            // Add order items to the transaction
            foreach ($order->items as $item) {
                $items[] = [
                    'id' => $item->id,
                    'price' => (int) ($item->price ?? $item->unit_price ?? 0),
                    'quantity' => (int) $item->quantity,
                    'name' => substr($item->orderable->name . ' - ' . ($item->subscription_type ?? '') . ' (' . ($item->duration ?? 1) . ' Month' . (($item->duration ?? 1) > 1 ? 's' : '') . ')', 0, 50),
                ];
            }
            
            // If there are no items (unlikely but possible), add a fallback item
            if (empty($items)) {
                $items[] = [
                    'id' => 'order-' . $order->id,
                    'price' => (int) $order->total,
                    'quantity' => 1,
                    'name' => 'Order #' . $order->order_number,
                ];
            }
            
            // Ensure each item has a price and validate total
            $total = 0;
            foreach ($items as &$item) {
                if (empty($item['price']) || !is_numeric($item['price'])) {
                    $item['price'] = 1000; // Default price if missing
                }
                $total += $item['price'] * $item['quantity'];
            }
            
            // Format customer details
            $customer_details = [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone ?? '',
                'billing_address' => [
                    'first_name' => $order->name,
                    'email' => $order->email,
                    'phone' => $order->whatsapp,
                    'country_code' => 'IDN'
                ]
            ];
            
            // Format transaction details - ensure gross_amount matches sum of items
            // If total from items doesn't match order total, use the calculated total
            $gross_amount = $total > 0 ? $total : max((int) $order->total, 10000);
            
            $transaction_details = [
                'order_id' => $order->order_number,
                'gross_amount' => $gross_amount,
            ];
            
            // Create the transaction parameters array
            $params = [
                'transaction_details' => $transaction_details,
                'customer_details' => $customer_details,
                'item_details' => $items,
                'enabled_payments' => [
                    'credit_card', 'cimb_clicks', 'bca_klikbca', 'bca_klikpay', 'bri_epay',
                    'echannel', 'permata_va', 'bca_va', 'bni_va', 'bri_va', 'cimb_va',
                    'other_va', 'gopay', 'indomaret', 'alfamart', 'shopeepay', 'qris'
                ],
                'callbacks' => [
                    'finish' => url('/payment/midtrans/finish'),
                    'error' => url('/payment/midtrans/error'),
                    'pending' => url('/payment/midtrans/unfinish')
                ]
            ];
            
            // Log the request parameters for debugging
            Log::info('Midtrans createToken params', [
                'transaction_details' => $transaction_details,
                'item_count' => count($items),
                'items_total' => $total
            ]);
            
            // Create token using Midtrans Snap
            $snapToken = Snap::getSnapToken($params);
            
            // Update the order with the token
            $order->update([
                'midtrans_token' => $snapToken
            ]);
            
            // Log successful token generation
            Log::info('Midtrans token generated successfully', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'token_length' => strlen($snapToken)
            ]);
            
            return response()->json([
                'token' => $snapToken,
                'redirect_url' => route('payment.midtrans.page', $order),
            ]);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Failed to create Midtrans token', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Failed to create payment. ' . $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Handle notification from Midtrans
     */
    public function handleNotification(Request $request)
    {
        try {
            $notification = new Notification();
            
            $orderNumber = $notification->order_id;
            $status = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;
            $transactionId = $notification->transaction_id;
            
            $order = Order::where('order_number', $orderNumber)->firstOrFail();
            
            // Handle transaction status
            if ($status == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $order->payment_status = 'challenged';
                } else if ($fraudStatus == 'accept') {
                    $order->payment_status = 'paid';
                    $order->status = 'processing';
                }
            } else if ($status == 'settlement') {
                $order->payment_status = 'paid';
                $order->status = 'processing';
            } else if ($status == 'cancel' || $status == 'deny' || $status == 'expire') {
                $order->payment_status = 'failed';
            } else if ($status == 'pending') {
                $order->payment_status = 'pending';
            }
            
            $order->save();
            
            // Update Midtrans transaction
            MidtransTransaction::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'transaction_id' => $transactionId,
                    'payment_type' => $notification->payment_type,
                    'transaction_time' => $notification->transaction_time,
                    'transaction_status' => $status,
                    'va_numbers' => json_encode($notification->va_numbers ?? []),
                    'fraud_status' => $fraudStatus,
                    'status_code' => $notification->status_code,
                    'status_message' => $notification->status_message,
                    'payment_code' => $notification->payment_code ?? null,
                    'pdf_url' => $notification->pdf_url ?? null,
                ]
            );
            
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Error processing Midtrans notification: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Redirect to Midtrans payment page
     */
    public function paymentPage(Order $order)
    {
        // If order doesn't have a Midtrans token yet, create one
        if (empty($order->midtrans_token)) {
            try {
                // Get fresh Snap token
                $response = $this->getSnapToken($order);
                $data = json_decode($response->getContent(), true);
                
                if (isset($data['error'])) {
                    Log::error('Failed to generate token in paymentPage', [
                        'order_id' => $order->id,
                        'error' => $data['error']
                    ]);
                    
                    return redirect()->route('user.payments.detail', $order)
                        ->with('error', 'Failed to connect to payment gateway. ' . $data['error']);
                }
                
                // Token should be saved to order in getSnapToken method
                // Refresh the order to get the latest token
                $order = $order->fresh();
                
                if (empty($order->midtrans_token)) {
                    Log::error('Token not saved to order', [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number
                    ]);
                    
                    return redirect()->route('user.payments.detail', $order)
                        ->with('error', 'Error preparing payment gateway. Please try again.');
                }
            } catch (\Exception $e) {
                Log::error('Exception in paymentPage', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage()
                ]);
                
                return redirect()->route('user.payments.detail', $order)
                    ->with('error', 'Failed to connect to payment gateway: ' . $e->getMessage());
            }
        }
        
        // Log debug information
        Log::info('Rendering payment page', [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'token' => !empty($order->midtrans_token) ? 'Set (length: '.strlen($order->midtrans_token).')' : 'Empty',
            'client_key' => !empty(config('midtrans.client_key')) ? 'Set' : 'Empty'
        ]);
        
        $agent = new Agent();
        $view = $agent->isMobile() ? 'pages.mobile.payment.midtrans' : 'pages.desktop.payment.midtrans';
        
        return view($view, [
            'order' => $order,
            'client_key' => config('midtrans.client_key'),
            'snap_url' => config('midtrans.snap_url'),
        ]);
    }
    
    /**
     * Check payment status for a specific order
     *
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkStatus(Order $order)
    {
        try {
            // Ensure Midtrans configuration is set
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            
            // Log debugging information
            Log::info('Checking Midtrans payment status', [
                'order_id' => $order->id,
                'order_number' => $order->order_number
            ]);
            
            // Get status from Midtrans API
            $status = Transaction::status($order->order_number);
            
            // Log the response
            Log::info('Midtrans status response', [
                'response' => $status,
                'transaction_status' => $status->transaction_status ?? 'not_available'
            ]);
            
            // Process the status
            if (isset($status->transaction_status)) {
                // Update the order status based on transaction status
                switch ($status->transaction_status) {
                    case 'settlement':
                    case 'capture':
                        $order->update([
                            'payment_status' => 'paid',
                            'status' => 'approved',
                            'paid_at' => now()
                        ]);
                        $message = 'Payment has been confirmed. Thank you for your purchase!';
                        $alertType = 'success';
                        break;
                        
                    case 'pending':
                        $order->update([
                            'payment_status' => 'pending'
                        ]);
                        $message = 'Payment is still pending. Please complete your payment to proceed.';
                        $alertType = 'info';
                        break;
                        
                    case 'deny':
                    case 'cancel':
                    case 'expire':
                    case 'failure':
                        $order->update([
                            'payment_status' => 'failed'
                        ]);
                        $message = 'Payment has been ' . $status->transaction_status . '. Please try again or contact support.';
                        $alertType = 'error';
                        break;
                        
                    default:
                        $message = 'Payment status: ' . $status->transaction_status;
                        $alertType = 'info';
                        break;
                }
                
                // Update or create Midtrans transaction record
                MidtransTransaction::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'transaction_id' => $status->transaction_id ?? null,
                        'payment_type' => $status->payment_type ?? null,
                        'transaction_time' => $status->transaction_time ?? null,
                        'transaction_status' => $status->transaction_status,
                        'status_code' => $status->status_code ?? null,
                        'status_message' => $status->status_message ?? null,
                    ]
                );
                
                return redirect()->route('user.payments.detail', $order)
                    ->with($alertType, $message);
            }
            
            // If no transaction status available
            return redirect()->route('user.payments.detail', $order)
                ->with('info', 'Unable to retrieve payment status. Please contact support if you have completed payment.');
                
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error checking Midtrans status', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('user.payments.detail', $order)
                ->with('error', 'Error checking payment status: ' . $e->getMessage());
        }
    }

    /**
     * Redirect directly to Midtrans VTWeb page
     * This is an alternative approach when the JavaScript popup doesn't work
     */
    public function redirectToVTWeb(Order $order)
    {
        try {
            // Ensure the order has a token
            if (empty($order->midtrans_token)) {
                // Get a fresh token
                $response = $this->getSnapToken($order);
                $data = json_decode($response->getContent(), true);
                
                if (isset($data['error'])) {
                    return redirect()->route('user.payments.detail', $order)
                        ->with('error', 'Failed to connect to payment gateway: ' . $data['error']);
                }
                
                // Fresh the order to get the updated token
                $order = $order->fresh();
            }
            
            // Log that we're redirecting to VTWeb
            Log::info('Redirecting to VTWeb', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'token' => $order->midtrans_token ? 'Yes (length: '.strlen($order->midtrans_token).')' : 'No'
            ]);
            
            // Check if we have a token
            if (empty($order->midtrans_token)) {
                return redirect()->route('user.payments.detail', $order)
                    ->with('error', 'Payment token not available. Please try again later.');
            }
            
            // Redirect to Midtrans VTWeb page
            return redirect()->away('https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $order->midtrans_token);
            
        } catch (\Exception $e) {
            Log::error('Error redirecting to VTWeb', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('user.payments.detail', $order)
                ->with('error', 'Failed to connect to payment gateway: ' . $e->getMessage());
        }
    }
}
