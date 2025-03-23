<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Run payment status updates every 15 minutes
        $schedule->command('payments:update-status')->everyFifteenMinutes();
        
        // Send reminders for unpaid orders every 3 hours
        $schedule->command('notifications:unpaid-reminders')->everyThreeHours();
        
        // Send reminders about unread notifications to admins daily at 9 AM
        $schedule->command('notifications:unread-reminders')->dailyAt('09:00');
        
        // ... existing scheduled tasks ...
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}   