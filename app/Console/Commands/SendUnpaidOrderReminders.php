<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\NotificationService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SendUnpaidOrderReminders extends Command
{
    protected $signature = 'notifications:unpaid-reminders';
    
    protected $description = 'Send reminders to users with unpaid orders';

    public function handle(NotificationService $notificationService): int
    {
        $this->info('Starting to send unpaid order reminders...');
        
        // Find orders that are unpaid for more than 6 hours but less than 24 hours
        $unpaidOrders = Order::where('status', 'pending')
            ->where('created_at', '<=', now()->subHours(6))
            ->where('created_at', '>=', now()->subHours(24))
            ->get();
            
        $this->info("Found {$unpaidOrders->count()} unpaid orders to send reminders for.");
            
        foreach ($unpaidOrders as $order) {
            $this->info("Sending reminder for order #{$order->order_number}");
            $notificationService->notifyUserAboutUnpaidOrder($order);
        }
        
        // Notify admin about orders that are unpaid for more than 24 hours
        $oldUnpaidOrders = Order::where('status', 'pending')
            ->where('created_at', '<=', now()->subHours(24))
            ->where('created_at', '>=', now()->subHours(48))
            ->get();
            
        $this->info("Found {$oldUnpaidOrders->count()} old unpaid orders to notify admin about.");
            
        foreach ($oldUnpaidOrders as $order) {
            $this->info("Notifying admin about order #{$order->order_number}");
            $notificationService->notifyAdminAboutUnpaidOrder($order);
        }
        
        $this->info('Finished sending unpaid order reminders.');
        
        return Command::SUCCESS;
    }
} 