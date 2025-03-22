<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;

class NewOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order)
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
            ->subject('Pesanan Baru: #' . $this->order->order_number)
            ->greeting('Hai Admin!')
            ->line('Pesanan baru telah dibuat dengan nomor pesanan #' . $this->order->order_number)
            ->line('Pelanggan: ' . $this->order->user->name)
            ->line('Total: Rp ' . number_format($this->order->total, 0, ',', '.'))
            ->action('Lihat Pesanan', url('/admin/resources/orders/' . $this->order->id . '/edit'))
            ->line('Terima kasih telah menggunakan aplikasi ini!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'customer' => $this->order->user->name,
            'total' => $this->order->total,
            'status' => $this->order->status,
        ];
    }

    /**
     * Send to Filament admin interface.
     */
    public static function make(Order $order): void
    {
        FilamentNotification::make()
            ->title('Pesanan Baru: #' . $order->order_number)
            ->icon('heroicon-o-shopping-cart')
            ->body('Pesanan baru dari ' . $order->user->name . ' senilai Rp ' . number_format($order->total, 0, ',', '.'))
            ->actions([
                Action::make('view')
                    ->label('Lihat')
                    ->url('/admin/resources/orders/' . $order->id . '/edit'),
            ])
            ->sendToDatabase(User::whereHas('roles', function($query) {
                $query->where('name', 'admin');
            })->get());
    }
}