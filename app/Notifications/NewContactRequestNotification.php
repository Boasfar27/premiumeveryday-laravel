<?php

namespace App\Notifications;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;

class NewContactRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Contact $contact)
    {
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Permintaan Kontak Baru: ' . $this->contact->subject)
            ->greeting('Hai Admin!')
            ->line('Anda menerima permintaan kontak baru dari ' . $this->contact->name)
            ->line('Email: ' . $this->contact->email)
            ->line('Subjek: ' . $this->contact->subject)
            ->line('Pesan: ' . $this->contact->message)
            ->action('Lihat Permintaan', url('/admin/resources/contacts/' . $this->contact->id . '/edit'))
            ->line('Terima kasih telah menggunakan aplikasi ini!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'contact_id' => $this->contact->id,
            'name' => $this->contact->name,
            'email' => $this->contact->email,
            'subject' => $this->contact->subject,
        ];
    }

    /**
     * Send to Filament admin interface.
     */
    public static function make(Contact $contact): void
    {
        FilamentNotification::make()
            ->title('Permintaan Kontak Baru')
            ->icon('heroicon-o-envelope')
            ->iconColor('warning')
            ->body('Dari: ' . $contact->name . ' (' . $contact->email . ') - ' . $contact->subject)
            ->actions([
                Action::make('view')
                    ->label('Lihat')
                    ->url('/admin/resources/contacts/' . $contact->id . '/edit'),
            ])
            ->sendToDatabase(User::whereHas('roles', function($query) {
                $query->where('name', 'admin');
            })->get());
    }
} 