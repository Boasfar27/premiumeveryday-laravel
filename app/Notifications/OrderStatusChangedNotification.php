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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusColor = $this->getStatusColor($this->newStatus);
        $statusLabel = $this->getStatusLabel($this->newStatus);
        $oldStatusLabel = $this->getStatusLabel($this->oldStatus);
        
        $message = (new MailMessage)
            ->subject('Status Pesanan Anda Berubah: #' . $this->order->order_number)
            ->greeting('Hai ' . $notifiable->name . '!')
            ->line('Status pesanan Anda dengan nomor #' . $this->order->order_number . ' telah berubah.')
            ->line("Status sebelumnya: <span style='color: #777777;'>{$oldStatusLabel}</span>")
            ->line("Status baru: <span style='color: {$statusColor};'><strong>{$statusLabel}</strong></span>");
        
        // Tambahkan informasi produk yang dibeli
        if ($this->order->items->count() > 0) {
            $message->line('<hr style="border:0;border-top:1px solid #eaeaea;margin:16px 0;">');
            $message->line('<strong style="font-size: 16px;">Detail Pesanan:</strong>');
            
            foreach ($this->order->items as $item) {
                $message->line(
                    "<div style='margin:10px 0;padding:10px;background:#f8f8f8;border-radius:5px;'>" .
                    "<strong>{$item->name}</strong><br>" .
                    "Jumlah: {$item->quantity} × Rp " . number_format($item->price, 0, ',', '.') . "<br>" .
                    "Total: Rp " . number_format($item->quantity * $item->price, 0, ',', '.') .
                    "</div>"
                );
            }
            
            $message->line('<hr style="border:0;border-top:1px solid #eaeaea;margin:16px 0;">');
            $message->line("<strong>Subtotal:</strong> Rp " . number_format($this->order->subtotal, 0, ',', '.'));
            
            if ($this->order->discount_amount > 0) {
                $message->line("<strong>Diskon:</strong> - Rp " . number_format($this->order->discount_amount, 0, ',', '.'));
            }
            
            $message->line("<strong>Pajak (PPN):</strong> Rp " . number_format($this->order->tax, 0, ',', '.'));
            $message->line("<strong style='font-size:16px;color:#000;'>Total:</strong> <strong style='font-size:16px;color:#000;'>Rp " . number_format($this->order->total, 0, ',', '.') . "</strong>");
        }

        // Tambahkan informasi tambahan berdasarkan status baru
        if ($this->newStatus === 'approved') {
            $message->line('<hr style="border:0;border-top:1px solid #eaeaea;margin:16px 0;">');
            $message->line('<div style="background:#e8f5e9;padding:10px;border-radius:5px;border-left:4px solid #4caf50;">
                <strong>Pesanan Anda telah disetujui dan sedang diproses.</strong><br>
                Anda akan menerima email lain ketika pesanan Anda selesai diproses.
            </div>');
        } elseif ($this->newStatus === 'delivered') {
            $message->line('<hr style="border:0;border-top:1px solid #eaeaea;margin:16px 0;">');
            $message->line('<div style="background:#e3f2fd;padding:10px;border-radius:5px;border-left:4px solid #2196f3;">
                <strong>Pesanan Anda telah berhasil dikirim!</strong><br>
                Silakan periksa email Anda untuk informasi akun dan instruksi penggunaan.
            </div>');
        } elseif ($this->newStatus === 'canceled') {
            $message->line('<hr style="border:0;border-top:1px solid #eaeaea;margin:16px 0;">');
            $message->line('<div style="background:#ffebee;padding:10px;border-radius:5px;border-left:4px solid #f44336;">
                <strong>Pesanan Anda telah dibatalkan.</strong><br>
                Silakan hubungi kami jika Anda memiliki pertanyaan.
            </div>');
        }

        $message->action('Lihat Pesanan', $this->getOrderUrl());
        $message->line('Terima kasih telah berbelanja di Premium Everyday!');
        
        // Tambahkan footer bantuan
        $message->line('<hr style="border:0;border-top:1px solid #eaeaea;margin:16px 0;">');
        $message->line('<p style="font-size:12px;color:#718096;">Butuh bantuan? Hubungi tim support kami melalui <a href="mailto:support@premium-everyday.com">support@premium-everyday.com</a> atau WhatsApp di +628123456789</p>');
        
        return $message;
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
