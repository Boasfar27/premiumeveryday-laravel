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
        // Gunakan view untuk email
        return (new MailMessage)
            ->subject('Produk Anda Telah Dikirim - Order #' . $this->order->order_number)
            ->view('emails.product-delivered', [
                'order' => $this->order
            ]);
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