<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        $agent = new Agent();
        $contacts = Contact::active()->get();
        
        return view(
            $agent->isMobile() ? 'pages.mobile.contact.index' : 'pages.desktop.contact.index',
            compact('contacts')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Create contact message in database
        $contactMessage = ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => ContactMessage::STATUS_PENDING,
        ]);

        // Send email notification
        try {
            Log::info('Attempting to send contact form email', [
                'to' => 'premiumeveryday2747@gmail.com',
                'from' => $request->email,
                'name' => $request->name,
                'subject' => $request->subject,
                'mail_config' => [
                    'mailer' => config('mail.default'),
                    'host' => config('mail.mailers.smtp.host'),
                    'port' => config('mail.mailers.smtp.port'),
                    'encryption' => config('mail.mailers.smtp.encryption'),
                    'username' => config('mail.mailers.smtp.username'),
                ]
            ]);
            
            // Create simple text message
            $messageText = "Pesan Kontak Baru dari Website\n\n";
            $messageText .= "Nama: " . $request->name . "\n";
            $messageText .= "Email: " . $request->email . "\n";
            $messageText .= "Subjek: " . $request->subject . "\n";
            $messageText .= "Pesan:\n" . $request->message . "\n\n";
            $messageText .= "Email ini dikirim otomatis dari Premium Everyday.";
            
            // Send using Laravel Mail
            Mail::raw($messageText, function($message) use ($request) {
                $message->to('premiumeveryday2747@gmail.com')
                        ->subject('Pesan Kontak Baru: ' . $request->subject)
                        ->replyTo($request->email);
            });
            
            Log::info('Email sent successfully');
            $contactMessage->update(['status' => ContactMessage::STATUS_SENT]);
            
        } catch (\Exception $e) {
            Log::error('Failed to send contact form email: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            // Mark as error but continue
            $contactMessage->update(['status' => ContactMessage::STATUS_ERROR]);
        }

        return back()->with('success', 'Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.');
    }
} 