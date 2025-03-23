<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductDeliveredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
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
        $items = $this->order->items->map(function ($item) {
            return $item->orderable->name . ' (' . ($item->subscription_type ?? 'Standard') . ')';
        })->implode(', ');

        return (new MailMessage)
            ->subject('Produk Anda Telah Dikirim - Order #' . $this->order->order_number)
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line('Kami dengan senang hati memberitahukan bahwa pesanan Anda dengan nomor #' . $this->order->order_number . ' telah diproses dan produk telah dikirim.')
            ->line('Produk yang Anda pesan:')
            ->line($items)
            ->line('Silakan periksa email Anda untuk informasi lebih lanjut tentang cara mengakses produk digital Anda.')
            ->line('Jika Anda memerlukan bantuan atau memiliki pertanyaan, jangan ragu untuk menghubungi kami.')
            ->action('Lihat Detail Pesanan', route('user.payments.detail', $this->order))
            ->line('Terima kasih atas kepercayaan Anda kepada Premium Everyday!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'title' => 'Produk Telah Dikirim',
            'message' => 'Produk Anda untuk pesanan #' . $this->order->order_number . ' telah dikirim.',
            'action_url' => route('user.payments.detail', $this->order),
            'icon' => 'paper-airplane',
            'icon_color' => 'text-green-500',
        ];
    }

    /**
     * Kirim notifikasi ke pengguna
     */
    public static function sendToUser(Order $order): void
    {
        $order->user->notify(new static($order));
    }
} 