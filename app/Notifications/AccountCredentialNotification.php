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

class AccountCredentialNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var array
     */
    protected $credentials;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Order $order, array $credentials)
    {
        $this->credentials = $credentials;
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
        // Siapkan URL pesanan
        $orderUrl = $this->getOrderUrl();
        
        // Gunakan view untuk email
        return (new MailMessage)
            ->subject('Informasi Akun Premium untuk Pesanan #' . $this->order->order_number)
            ->view('emails.account-credential', [
                'order' => $this->order,
                'credentials' => $this->credentials,
                'orderUrl' => $orderUrl
            ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        // URL ke halaman detail pesanan
        try {
            $link = route('user.payments.detail', ['order' => $this->order->id]);
        } catch (\Exception $e) {
            // Fallback URL jika route tidak ditemukan
            $link = url('/user/payments/' . $this->order->id);
        }
        
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'message' => 'Informasi akun premium untuk pesanan #' . $this->order->order_number . ' telah tersedia',
            'link' => $link,
            'route_name' => 'user.payments.detail',
            'route_params' => ['order' => $this->order->id],
            'notif_type' => 'account_credentials',
            'product_name' => $this->order->items->first()->name ?? '',
            'expires_at' => $this->credentials['expired_at'] ?? ''
        ];
    }

    /**
     * Get the order URL
     */
    private function getOrderUrl(): string
    {
        // Gunakan route user.payments.detail untuk detail pesanan
        try {
            return route('user.payments.detail', ['order' => $this->order->id]);
        } catch (\Exception $e) {
            // Fallback jika route tidak ditemukan
            return url('/user/payments/' . $this->order->id);
        }
    }
} 