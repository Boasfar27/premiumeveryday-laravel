<?php

namespace App\Console\Commands;

use App\Services\NotificationService;
use Illuminate\Console\Command;

class SendUnreadNotificationsReminder extends Command
{
    protected $signature = 'notifications:unread-reminders';
    
    protected $description = 'Send reminders to admins about unread notifications';

    public function handle(NotificationService $notificationService): int
    {
        $this->info('Starting to send unread notifications reminders...');
        
        $notificationService->sendUnreadNotificationsReminder();
        
        $this->info('Finished sending unread notifications reminders.');
        
        return Command::SUCCESS;
    }
} 