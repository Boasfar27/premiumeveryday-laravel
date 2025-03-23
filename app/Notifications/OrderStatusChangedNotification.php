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

class OrderStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Order $order,
        public string $oldStatus,
        public string $newStatus
    ) {
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        // Hanya kirim email jika status baru adalah 'delivered'
        // Notifikasi database tetap dikirim untuk semua perubahan status
        if ($this->newStatus === 'delivered') {
            return ['mail', 'database'];
        }
        
        return ['database']; // Hanya kirim ke database untuk status lainnya
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $orderUrl = $this->getOrderUrl();
        $oldStatusLabel = $this->getStatusLabel($this->oldStatus);
        $newStatusLabel = $this->getStatusLabel($this->newStatus);
        
        // Gunakan view untuk email
        return (new MailMessage)
            ->subject('Status Pesanan Anda Berubah: #' . $this->order->order_number)
            ->view('emails.order-status-changed', [
                'order' => $this->order,
                'oldStatus' => $this->oldStatus,
                'newStatus' => $this->newStatus,
                'oldStatusLabel' => $oldStatusLabel,
                'newStatusLabel' => $newStatusLabel,
                'orderUrl' => $orderUrl
            ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        // Gunakan nama route yang valid untuk user untuk link detail order
        try {
            $link = route('user.payments.detail', ['order' => $this->order->id]);
        } catch (\Exception $e) {
            // Fallback URL jika route tidak ditemukan
            $link = url('/user/payments/' . $this->order->id);
        }
        
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => 'Status pesanan Anda #' . $this->order->order_number . ' telah berubah dari ' . 
                $this->getStatusLabel($this->oldStatus) . ' menjadi ' . $this->getStatusLabel($this->newStatus),
            'link' => $link,
            'route_name' => 'user.payments.detail',
            'route_params' => ['order' => $this->order->id],
            'notif_type' => 'order_status'
        ];
    }

    /**
     * Get the status label
     */
    private function getStatusLabel(string $status): string
    {
        return match ($status) {
            'pending' => 'Menunggu Pembayaran',
            'approved' => 'Disetujui',
            'processing' => 'Sedang Diproses',
            'delivered' => 'Terkirim',
            'canceled' => 'Dibatalkan',
            default => ucfirst($status),
        };
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
     * Send notification to user
     */
    public static function sendToUser(Order $order, string $oldStatus, string $newStatus): void
    {
        $user = $order->user;
        if ($user) {
            $user->notify(new OrderStatusChangedNotification($order, $oldStatus, $newStatus));
        }
    }

    /**
     * Notify admin about order status change
     */
    public static function notifyAdmin(Order $order, string $oldStatus, string $newStatus): void
    {
        $statusLabel = match ($newStatus) {
            'pending' => 'Menunggu Pembayaran',
            'approved' => 'Disetujui',
            'processing' => 'Sedang Diproses',
            'delivered' => 'Terkirim',
            'canceled' => 'Dibatalkan',
            default => ucfirst($newStatus),
        };
        
        // Tentukan URL admin berdasarkan tipe order menggunakan route
        $adminUrl = self::getAdminOrderUrl($order);

        FilamentNotification::make()
            ->title('Status Pesanan Berubah: #' . $order->order_number)
            ->icon('heroicon-o-arrow-path')
            ->iconColor('success')
            ->body('Status pesanan #' . $order->order_number . ' berubah dari ' . 
                ucfirst($oldStatus) . ' menjadi ' . $statusLabel)
            ->actions([
                Action::make('view')
                    ->label('Lihat')
                    ->url($adminUrl),
            ])
            ->sendToDatabase(User::where('role', 1)->get());
    }
    
    /**
     * Get admin URL for order
     */
    private static function getAdminOrderUrl(Order $order): string
    {
        try {
            // Parameter untuk route admin harus menggunakan 'record' bukan 'id'
            return route('filament.admin.resources.orders.edit', ['record' => $order->id]);
        } catch (\Exception $e) {
            // Fallback jika route tidak ditemukan
            Log::error('Admin order URL error: ' . $e->getMessage());
            return '/admin/orders/' . $order->id . '/edit';
        }
    }
    
    /**
     * Static method to check if order is digital
     */
    private static function isDigitalOrderStatic(Order $order): bool
    {
        // Tidak perlu lagi membedakan digital/fisik karena URL sama
        return false;
    }

    /**
     * Get the status color for styling
     */
    private function getStatusColor(string $status): string
    {
        return match ($status) {
            'pending' => '#ffa000',   // Amber
            'approved' => '#4caf50',  // Green
            'processing' => '#2196f3', // Blue
            'delivered' => '#009688', // Teal
            'canceled' => '#f44336',  // Red
            default => '#757575',     // Grey
        };
    }
}
