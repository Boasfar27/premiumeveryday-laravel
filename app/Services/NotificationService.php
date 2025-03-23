<?php

namespace App\Services;

use App\Models\License;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\User;
use App\Notifications\LicenseDeliveredNotification;
use App\Notifications\NewOrderNotification;
use App\Notifications\NewProductNotification;
use App\Notifications\NewPromotionNotification;
use App\Notifications\PaymentConfirmationNotification;
use App\Notifications\UnpaidOrderNotification;

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
     */
    public function notifyUsersAboutNewProduct(Product $product): void
    {
        NewProductNotification::sendToAllUsers($product);
    }

    /**
     * Notify admin when new product is created
     */
    public function notifyAdminAboutNewProduct(Product $product): void
    {
        NewProductNotification::notifyAdmin($product);
    }

    /**
     * Send notification to admin users about unread notifications
     */
    public function sendUnreadNotificationsReminder(): void
    {
        $admins = User::whereHas('roles', function($query) {
            $query->where('name', 'admin');
        })->get();

        foreach ($admins as $admin) {
            $unreadCount = $admin->unreadNotifications->count();
            
            if ($unreadCount > 0) {
                $admin->notify(new \App\Notifications\UnreadNotificationsReminder($unreadCount));
            }
        }
    }
} 