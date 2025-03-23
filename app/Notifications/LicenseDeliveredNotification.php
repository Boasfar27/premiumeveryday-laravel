<?php

namespace App\Notifications;

use App\Models\License;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;

class LicenseDeliveredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public License $license)
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
            ->subject('Akun/Lisensi Anda Siap Digunakan')
            ->greeting('Hai ' . $notifiable->name . '!')
            ->line('Akun/Lisensi untuk "' . $this->license->product->name . '" telah siap untuk digunakan.')
            ->line('Anda dapat melihat detail akun/lisensi di halaman akun Anda.')
            ->action('Lihat Lisensi', url('/licenses/' . $this->license->id))
            ->line('Terima kasih telah berbelanja di Premium Everyday!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'license_id' => $this->license->id,
            'product_name' => $this->license->product->name,
            'message' => 'Akun/Lisensi "' . $this->license->product->name . '" telah siap digunakan',
            'link' => '/licenses/' . $this->license->id
        ];
    }

    /**
     * Send to user
     */
    public static function sendToUser(License $license): void
    {
        $license->user->notify(new LicenseDeliveredNotification($license));
    }

    /**
     * Notify admin about license delivery
     */
    public static function notifyAdmin(License $license): void
    {
        FilamentNotification::make()
            ->title('Lisensi Berhasil Dikirim')
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->body('Lisensi "' . $license->product->name . '" telah berhasil dikirim ke ' . $license->user->name)
            ->actions([
                Action::make('view')
                    ->label('Lihat')
                    ->url('/admin/resources/licenses/' . $license->id . '/edit'),
            ])
            ->sendToDatabase(User::where('role', 1)->get());
    }
} 