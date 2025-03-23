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

class PaymentConfirmationNotification extends Notification implements ShouldQueue
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
            ->subject('Pembayaran Berhasil: #' . $this->order->order_number)
            ->greeting('Hai ' . $notifiable->name . '!')
            ->line('Pembayaran untuk pesanan #' . $this->order->order_number . ' telah berhasil.')
            ->line('Total: Rp ' . number_format($this->order->total, 0, ',', '.'))
            ->line('Tim kami sedang memproses pesanan Anda.')
            ->action('Lihat Pesanan', url('/orders/' . $this->order->id))
            ->line('Terima kasih telah berbelanja di Premium Everyday!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'total' => $this->order->total,
            'message' => 'Pembayaran untuk pesanan #' . $this->order->order_number . ' telah berhasil',
            'link' => '/orders/' . $this->order->id
        ];
    }

    /**
     * Send to user
     */
    public static function sendToUser(Order $order): void
    {
        $order->user->notify(new PaymentConfirmationNotification($order));
    }

    /**
     * Notify admin about payment
     */
    public static function notifyAdmin(Order $order): void
    {
        FilamentNotification::make()
            ->title('Pembayaran Diterima')
            ->icon('heroicon-o-currency-dollar')
            ->iconColor('success')
            ->body('Pembayaran untuk pesanan #' . $order->order_number . ' dari ' . $order->user->name . ' telah diterima')
            ->actions([
                Action::make('view')
                    ->label('Lihat')
                    ->url('/admin/resources/orders/' . $order->id . '/edit'),
            ])
            ->sendToDatabase(User::where('role', 1)->get());
    }
} 