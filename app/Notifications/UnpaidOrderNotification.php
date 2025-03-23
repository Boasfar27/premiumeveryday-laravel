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

class UnpaidOrderNotification extends Notification implements ShouldQueue
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
            ->subject('Pesanan Menunggu Pembayaran: #' . $this->order->order_number)
            ->greeting('Hai ' . $notifiable->name . '!')
            ->line('Pesanan Anda dengan nomor #' . $this->order->order_number . ' menunggu pembayaran.')
            ->line('Total: Rp ' . number_format($this->order->total, 0, ',', '.'))
            ->action('Bayar Sekarang', url('/orders/' . $this->order->id))
            ->line('Silahkan selesaikan pembayaran Anda untuk memproses pesanan Anda.');
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
            'message' => 'Pesanan #' . $this->order->order_number . ' menunggu pembayaran',
            'link' => '/orders/' . $this->order->id
        ];
    }

    /**
     * Send to Filament admin interface.
     */
    public static function sendToUser(Order $order): void
    {
        $order->user->notify(new UnpaidOrderNotification($order));
    }

    /**
     * Send reminder to admin about unpaid orders
     */
    public static function sendToAdmin(Order $order): void
    {
        FilamentNotification::make()
            ->title('Pesanan Belum Dibayar: #' . $order->order_number)
            ->icon('heroicon-o-exclamation-circle')
            ->iconColor('warning')
            ->body('Pesanan #' . $order->order_number . ' dari ' . $order->user->name . ' belum dibayar')
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