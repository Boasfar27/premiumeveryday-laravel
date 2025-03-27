<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmission;
use Illuminate\Support\Facades\Log;

class TestMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {email? : The email to send the test to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to verify mail configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?: 'premiumeveryday2747@gmail.com';
        
        $this->info("Sending test email to: {$email}");
        $this->info("Mail configuration:");
        $this->info("MAIL_MAILER: " . config('mail.default'));
        $this->info("MAIL_HOST: " . config('mail.mailers.smtp.host'));
        $this->info("MAIL_PORT: " . config('mail.mailers.smtp.port'));
        $this->info("MAIL_USERNAME: " . config('mail.mailers.smtp.username'));
        $this->info("MAIL_ENCRYPTION: " . config('mail.mailers.smtp.encryption'));
        $this->info("MAIL_FROM_ADDRESS: " . config('mail.from.address'));
        
        try {
            Mail::to($email)->send(new ContactFormSubmission([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'message' => 'This is a test message sent at ' . now() . ' to verify the email configuration is working correctly.',
            ]));
            
            $this->info("Test email sent successfully! Please check your inbox (and spam folder).");
            Log::info("Test email sent to {$email}");
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Failed to send test email: " . $e->getMessage());
            Log::error("Test email failed: " . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            return Command::FAILURE;
        }
    }
}
