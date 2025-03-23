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
        // Buat tampilan email yang lebih menarik dengan style
        $message = (new MailMessage)
            ->subject('Pembayaran Berhasil untuk Pesanan #' . $this->order->order_number)
            ->greeting('Hai ' . $notifiable->name . '!')
            ->line('<div style="background:#e8f5e9;padding:15px;border-radius:5px;border-left:4px solid #4caf50;margin-bottom:15px;">
                <strong style="font-size:16px;">Pembayaran Anda telah berhasil!</strong><br>
                Terima kasih atas pembayaran Anda untuk pesanan #' . $this->order->order_number . '.
            </div>');

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

        // Tambahkan informasi metode pembayaran
        if ($this->order->midtransTransaction) {
            $paymentType = $this->formatPaymentType($this->order->midtransTransaction->payment_type ?? '');
            
            $message->line('<hr style="border:0;border-top:1px solid #eaeaea;margin:16px 0;">');
            $message->line('<strong style="font-size: 16px;">Informasi Pembayaran:</strong>');
            $message->line("<div style='margin:10px 0;padding:10px;background:#f8f8f8;border-radius:5px;'>" .
                "<strong>Metode Pembayaran:</strong> {$paymentType}<br>" .
                "<strong>Status Pembayaran:</strong> <span style='color:#4caf50;'>Berhasil</span><br>" .
                "<strong>Tanggal Pembayaran:</strong> " . ($this->order->paid_at ? $this->order->paid_at->format('d M Y H:i') : now()->format('d M Y H:i')) .
                "</div>");
        }

        // Tambahkan status pesanan
        $message->line('<hr style="border:0;border-top:1px solid #eaeaea;margin:16px 0;">');
        $message->line('<strong style="font-size: 16px;">Status Pesanan:</strong>');
        $message->line("<div style='margin:10px 0;padding:10px;background:#f0f4c3;border-radius:5px;border-left:4px solid #cddc39;'>" .
            "<strong>Status saat ini:</strong> " . $this->getStatusLabel($this->order->status) . "<br>" .
            "<strong>Estimasi proses:</strong> 1-2 jam kerja" .
            "</div>");

        // Tambahkan langkah selanjutnya dan tombol aksi
        $message->line('<div style="margin:16px 0;padding:10px;background:#e3f2fd;border-radius:5px;border-left:4px solid #2196f3;">
            Tim kami akan memproses pesanan Anda segera. Anda akan menerima informasi akun melalui email setelah pesanan diproses.
        </div>');
        
        $message->action('Lihat Detail Pesanan', $this->getOrderUrl());
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

    /**
     * Format payment type for better readability
     */
    private function formatPaymentType($type): string
    {
        return match ($type) {
            'bank_transfer' => 'Transfer Bank',
            'cstore' => 'Convenience Store',
            'credit_card' => 'Kartu Kredit',
            'gopay' => 'GoPay',
            'shopeepay' => 'ShopeePay',
            'qris' => 'QRIS',
            default => ucfirst(str_replace('_', ' ', $type)),
        };
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
} 