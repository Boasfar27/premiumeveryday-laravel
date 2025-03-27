<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendTestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {recipient?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to verify email configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $recipient = $this->argument('recipient') ?? 'premiumeveryday2747@gmail.com';
        
        $this->info("Attempting to send test email to: {$recipient}");
        $this->info("Current mail configuration:");
        $this->info("MAIL_MAILER: " . config('mail.default'));
        $this->info("MAIL_HOST: " . config('mail.mailers.smtp.host'));
        $this->info("MAIL_PORT: " . config('mail.mailers.smtp.port'));
        $this->info("MAIL_USERNAME: " . config('mail.mailers.smtp.username'));
        $this->info("MAIL_ENCRYPTION: " . config('mail.mailers.smtp.encryption'));
        $this->info("MAIL_FROM_ADDRESS: " . config('mail.from.address'));
        $this->info("MAIL_FROM_NAME: " . config('mail.from.name'));
        
        try {
            // First try with Mail facade
            $this->info("Attempting to send email using Mail facade...");
            Mail::raw('This is a test email from Premium Everyday application to verify that the email configuration is working correctly.', function($message) use ($recipient) {
                $message->to($recipient)
                        ->subject('Test Email from Premium Everyday');
            });
            
            $this->info("Mail facade email sent successfully!");
            
            // Then try with mail() function
            $this->info("Attempting to send email using mail() function...");
            $to = $recipient;
            $subject = 'Test Email from Premium Everyday (mail function)';
            $message = 'This is a test email sent using the PHP mail() function to verify that the server mail configuration is working correctly.';
            $headers = [
                'From' => config('mail.from.address'),
                'Reply-To' => config('mail.from.address'),
                'X-Mailer' => 'PHP/' . phpversion(),
                'MIME-Version' => '1.0',
                'Content-Type' => 'text/plain; charset=utf-8'
            ];
            
            $headerString = '';
            foreach ($headers as $name => $value) {
                $headerString .= "$name: $value\r\n";
            }
            
            if (mail($to, $subject, $message, $headerString)) {
                $this->info("mail() function email sent successfully!");
            } else {
                $this->error("mail() function failed to send email!");
            }
            
            $this->info("Please check your inbox (and spam folder) for the test emails.");
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Failed to send email: " . $e->getMessage());
            Log::error('Test email sending failed', [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return Command::FAILURE;
        }
    }
}
