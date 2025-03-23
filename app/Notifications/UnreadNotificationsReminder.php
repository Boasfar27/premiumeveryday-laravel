<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UnreadNotificationsReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $unreadCount)
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
            ->subject('Anda Memiliki ' . $this->unreadCount . ' Notifikasi Belum Dibaca')
            ->greeting('Hai ' . $notifiable->name . '!')
            ->line('Anda memiliki ' . $this->unreadCount . ' notifikasi yang belum dibaca.')
            ->line('Silakan periksa panel admin untuk mengetahui informasi terbaru.')
            ->action('Lihat Notifikasi', url('/admin'))
            ->line('Terima kasih telah menggunakan aplikasi Premium Everyday!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'unread_count' => $this->unreadCount,
            'message' => 'Anda memiliki ' . $this->unreadCount . ' notifikasi yang belum dibaca',
            'link' => '/admin'
        ];
    }
} 