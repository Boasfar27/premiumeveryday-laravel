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
use Illuminate\Support\Facades\Log;

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
            ->action('Lihat Pesanan', $this->getOrderUrl())
            ->line('Terima kasih telah berbelanja di Premium Everyday!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        // Gunakan nama route yang valid untuk user untuk link detail pembayaran
        try {
            $link = route('user.payments.detail', ['order' => $this->order->id]);
        } catch (\Exception $e) {
            // Fallback URL jika route tidak ditemukan
            $link = url('/user/payments/' . $this->order->id);
        }
        
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'total' => $this->order->total,
            'message' => 'Pembayaran untuk pesanan #' . $this->order->order_number . ' telah berhasil',
            'link' => $link,
            'route_name' => 'user.payments.detail',
            'route_params' => ['order' => $this->order->id],
            'notif_type' => 'payment_confirmation'
        ];
    }

    /**
     * Get the order URL based on order type
     */
    private function getOrderUrl(): string
    {
        // Gunakan nama route untuk menghasilkan URL
        try {
            return route('user.payments.detail', ['order' => $this->order->id]);
        } catch (\Exception $e) {
            // Fallback URL jika route tidak ditemukan
            return url('/user/payments/' . $this->order->id);
        }
    }
    
    /**
     * Get the order link for internal references
     */
    private function getOrderLink(): string
    {
        // Internal link untuk notifications page
        // Gunakan /notifications/{id}/read untuk membuka notifikasi via notifications page
        // (ID akan diisi oleh sistem notifikasi Laravel)
        return '/notifications/{id}/read';
    }
    
    /**
     * Check if order is digital
     */
    private function isDigitalOrder(): bool
    {
        // Tidak perlu lagi membedakan digital/fisik karena URL sama
        return false;
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
        // Gunakan route untuk URL admin
        try {
            $adminUrl = route('filament.admin.resources.orders.edit', ['record' => $order->id]);
        } catch (\Exception $e) {
            // Fallback jika route tidak ditemukan
            Log::error('Admin URL error: ' . $e->getMessage());
            $adminUrl = '/admin/orders/' . $order->id . '/edit';
        }
        
        FilamentNotification::make()
            ->title('Pembayaran Diterima')
            ->icon('heroicon-o-currency-dollar')
            ->iconColor('success')
            ->body('Pembayaran untuk pesanan #' . $order->order_number . ' dari ' . $order->user->name . ' telah diterima')
            ->actions([
                Action::make('view')
                    ->label('Lihat')
                    ->url($adminUrl),
            ])
            ->sendToDatabase(User::where('role', 1)->get());
    }
} 