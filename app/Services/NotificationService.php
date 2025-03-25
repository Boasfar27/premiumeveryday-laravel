<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\License;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\User;
use App\Notifications\LicenseDeliveredNotification;
use App\Notifications\NewCouponNotification;
use App\Notifications\NewOrderNotification;
use App\Notifications\NewProductNotification;
use App\Notifications\NewPromotionNotification;
use App\Notifications\PaymentConfirmationNotification;
use App\Notifications\UnpaidOrderNotification;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Send notification about a new order to admin
     */
    public function notifyAdminAboutNewOrder(Order $order): void
    {
        NewOrderNotification::make($order);
    }

    /**
     * Send notification about unpaid orders to users
     */
    public function notifyUserAboutUnpaidOrder(Order $order): void
    {
        UnpaidOrderNotification::sendToUser($order);
    }

    /**
     * Send notification about unpaid orders to admin
     */
    public function notifyAdminAboutUnpaidOrder(Order $order): void
    {
        UnpaidOrderNotification::sendToAdmin($order);
    }

    /**
     * Send notification to user when payment is confirmed
     */
    public function notifyUserAboutPaymentConfirmation(Order $order): void
    {
        PaymentConfirmationNotification::sendToUser($order);
    }

    /**
     * Send notification to admin when payment is confirmed
     */
    public function notifyAdminAboutPaymentConfirmation(Order $order): void
    {
        PaymentConfirmationNotification::notifyAdmin($order);
    }

    /**
     * Send notification to user when license is delivered
     */
    public function notifyUserAboutLicenseDelivery(License $license): void
    {
        LicenseDeliveredNotification::sendToUser($license);
    }

    /**
     * Notify admin when license is delivered
     */
    public function notifyAdminAboutLicenseDelivery(License $license): void
    {
        LicenseDeliveredNotification::notifyAdmin($license);
    }

    /**
     * Send notification to all users about new promotion
     */
    public function notifyUsersAboutNewPromotion(Promotion $promotion): void
    {
        NewPromotionNotification::sendToAllUsers($promotion);
    }

    /**
     * Notify admin when new promotion is created
     */
    public function notifyAdminAboutNewPromotion(Promotion $promotion): void
    {
        NewPromotionNotification::notifyAdmin($promotion);
    }

    /**
     * Send notification to all users about new product
     * 
     * @param Product|DigitalProduct $product
     */
    public function notifyUsersAboutNewProduct($product): void
    {
        NewProductNotification::sendToAllUsers($product);
    }

    /**
     * Notify admin when new product is created
     * 
     * @param Product|DigitalProduct $product
     */
    public function notifyAdminAboutNewProduct($product): void
    {
        NewProductNotification::notifyAdmin($product);
    }

    /**
     * Send notification to all users about new coupon
     */
    public function notifyUsersAboutNewCoupon(Coupon $coupon): void
    {
        NewCouponNotification::sendToAllUsers($coupon);
    }

    /**
     * Notify admin when new coupon is created
     */
    public function notifyAdminAboutNewCoupon(Coupon $coupon): void
    {
        NewCouponNotification::notifyAdmin($coupon);
    }

    /**
     * Send notification to admin users about unread notifications
     */
    public function sendUnreadNotificationsReminder(): void
    {
        $admins = User::where('role', 1)->get();

        foreach ($admins as $admin) {
            $unreadCount = $admin->unreadNotifications->count();
            
            if ($unreadCount > 0) {
                $admin->notify(new \App\Notifications\UnreadNotificationsReminder($unreadCount));
            }
        }
    }

    /**
     * Send notification to user about order status change
     */
    public function notifyOrderStatusChange(Order $order, string $oldStatus, string $newStatus): void
    {
        // Kirim notifikasi ke user
        \App\Notifications\OrderStatusChangedNotification::sendToUser($order, $oldStatus, $newStatus);
        
        // Kirim notifikasi ke admin
        \App\Notifications\OrderStatusChangedNotification::notifyAdmin($order, $oldStatus, $newStatus);
    }

    /**
     * Kirim informasi akun dan kredensial ke pengguna
     *
     * @param Order $order
     * @param array $accountCredentials
     * @return void
     */
    public function sendAccountCredentials(Order $order, array $accountCredentials)
    {
        // Kirim notifikasi ke pengguna
        $order->user->notify(new \App\Notifications\AccountCredentialNotification($order, $accountCredentials));
        
        // Log aktivitas
        Log::info('Account credentials sent to user', [
            'user_id' => $order->user->id,
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'credentials_count' => count($accountCredentials),
        ]);
    }
    
    /**
     * Update status pesanan dan beri tahu pengguna
     *
     * @param Order $order
     * @param string $newStatus
     * @return void 
     */
    public function updateOrderStatus(Order $order, string $newStatus)
    {
        $oldStatus = $order->status;
        
        // Jangan proses jika tidak ada perubahan status
        if ($oldStatus === $newStatus) {
            return;
        }
        
        // Update status pesanan
        $order->status = $newStatus;
        $order->save();
        
        // Kirim notifikasi ke user
        \App\Notifications\OrderStatusChangedNotification::sendToUser($order, $oldStatus, $newStatus);
        
        // Kirim notifikasi ke admin
        \App\Notifications\OrderStatusChangedNotification::notifyAdmin($order, $oldStatus, $newStatus);
        
        // Kirim informasi akun jika status menjadi 'approved'
        if ($newStatus === 'approved') {
            // Kirim email informasi akun (harus dibuat dulu)
            // Contoh data akun (akan diisi dengan data sebenarnya oleh admin)
            $accountCredentials = [
                'username' => 'username_akun',
                'password' => 'password_akun',
                'type' => $order->items->first()->subscription_type ?? 'monthly',
                'duration' => $order->items->first()->duration ?? 1,
                'expired_at' => now()->addMonths($order->items->first()->duration ?? 1)->format('d M Y'),
                'instructions' => 'Langkah-langkah penggunaan akun'
            ];
            
            $this->sendAccountCredentials($order, $accountCredentials);
        }
    }

    /**
     * Kirim notifikasi kepada pengguna bahwa produk telah dikirim
     *
     * @param Order $order
     * @return void
     */
    public function notifyUserAboutProductDelivery(Order $order): void
    {
        // Jika produk adalah produk digital
        if ($order->items->count() > 0) {
            // Kirim notifikasi ke user
            $order->user->notify(new \App\Notifications\ProductDeliveredNotification($order));
            
            // Kirim kredensial akun jika ada
            $items = $order->items;
            $accountCredentials = [];
            
            foreach ($items as $item) {
                if (method_exists($item->orderable, 'getCredentials')) {
                    $credentials = $item->orderable->getCredentials();
                    if (!empty($credentials)) {
                        $accountCredentials[] = array_merge(
                            $credentials,
                            [
                                'product_name' => $item->orderable->name,
                                'type' => $item->subscription_type ?? 'standard',
                                'duration' => $item->duration ?? 1,
                                'expired_at' => now()->addMonths($item->duration ?? 1)->format('d M Y'),
                            ]
                        );
                    }
                }
            }
            
            // Jika ada kredensial, kirim ke pengguna
            if (!empty($accountCredentials)) {
                $this->sendAccountCredentials($order, $accountCredentials);
            }
        }
        
        // Update status pesanan menjadi completed
        $oldStatus = $order->status;
        // Gunakan 'approved' karena 'completed' tidak sesuai dengan enum di database
        // Tambahkan informasi di admin_notes bahwa pesanan telah selesai
        $order->admin_notes = ($order->admin_notes ? $order->admin_notes . "\n\n" : '') . 
                               'Pesanan telah diselesaikan pada: ' . now()->format('d M Y H:i');
        $order->save();
        
        // Kirim notifikasi perubahan status dengan informasi bahwa pesanan telah selesai
        $this->notifyOrderStatusChange($order, $oldStatus, $order->status);
        
        // Log aktivitas
        \Illuminate\Support\Facades\Log::info('Product delivered notification sent', [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'user_id' => $order->user_id,
        ]);
    }
} 