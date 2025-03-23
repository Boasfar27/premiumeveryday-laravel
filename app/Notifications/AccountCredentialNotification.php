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
        // Membuat email dengan desain yang menarik
        $message = (new MailMessage)
            ->subject('Informasi Akun Premium untuk Pesanan #' . $this->order->order_number)
            ->greeting('Hai ' . $notifiable->name . '!')
            ->line('<div style="background:#e8f5e9;padding:15px;border-radius:5px;border-left:4px solid #4caf50;margin-bottom:15px;">
                <strong style="font-size:16px;">Pesanan Anda telah diproses!</strong><br>
                Berikut adalah informasi akun premium Anda untuk Pesanan #' . $this->order->order_number . '.
            </div>');

        // Informasi pesanan
        $message->line('<hr style="border:0;border-top:1px solid #eaeaea;margin:16px 0;">');
        $message->line('<strong style="font-size: 16px;">Produk Yang Dibeli:</strong>');
        
        foreach ($this->order->items as $item) {
            $message->line(
                "<div style='margin:10px 0;padding:10px;background:#f8f8f8;border-radius:5px;'>" .
                "<strong>{$item->name}</strong><br>" .
                "Tipe Langganan: " . ucfirst($item->subscription_type ?? 'Bulanan') . "<br>" .
                "Durasi: " . ($item->duration ?? 1) . " bulan" .
                "</div>"
            );
        }

        // Informasi akun dan kredensial
        $message->line('<hr style="border:0;border-top:1px solid #eaeaea;margin:16px 0;">');
        $message->line('<strong style="font-size: 16px;">Informasi Akun:</strong>');
        
        $message->line(
            "<div style='margin:10px 0;padding:15px;background:#e3f2fd;border-radius:5px;border-left:4px solid #2196f3;'>" .
            "<strong>Username/Email:</strong> {$this->credentials['username']}<br>" .
            "<strong>Password:</strong> {$this->credentials['password']}<br>" .
            "<strong>Masa Berlaku:</strong> Hingga {$this->credentials['expired_at']}" .
            "</div>"
        );

        // Instruksi penggunaan
        $message->line('<hr style="border:0;border-top:1px solid #eaeaea;margin:16px 0;">');
        $message->line('<strong style="font-size: 16px;">Cara Penggunaan:</strong>');
        
        $message->line(
            "<div style='margin:10px 0;padding:10px;background:#f3e5f5;border-radius:5px;border-left:4px solid #9c27b0;'>" .
            "<ol style='margin-left:20px;padding-left:0;'>" .
            "<li>Login ke layanan menggunakan username dan password di atas</li>" .
            "<li>Setelah login, silakan pilih paket yang telah Anda beli</li>" .
            "<li>Nikmati semua fitur premium yang tersedia</li>" .
            "<li>Hubungi kami jika ada kendala dalam penggunaan</li>" .
            "</ol>" .
            "</div>"
        );

        // Catatan penting
        $message->line('<hr style="border:0;border-top:1px solid #eaeaea;margin:16px 0;">');
        $message->line('<strong style="font-size: 16px;color:#f44336;">Catatan Penting:</strong>');
        $message->line(
            "<div style='margin:10px 0;padding:10px;background:#ffebee;border-radius:5px;border-left:4px solid #f44336;'>" .
            "<ul style='margin-left:20px;padding-left:0;'>" .
            "<li>Jangan membagikan informasi akun ini kepada orang lain</li>" .
            "<li>Penggunaan akun diluar ketentuan dapat menyebabkan penangguhan akun</li>" .
            "<li>Simpan informasi akun ini di tempat yang aman</li>" .
            "</ul>" .
            "</div>"
        );

        // Tombol aksi
        $message->action('Lihat Detail Pesanan', $this->getOrderUrl());
        $message->line('Terima kasih telah berbelanja di Premium Everyday!');
        
        // Footer bantuan
        $message->line('<hr style="border:0;border-top:1px solid #eaeaea;margin:16px 0;">');
        $message->line('<p style="font-size:12px;color:#718096;">Butuh bantuan? Hubungi tim support kami melalui <a href="mailto:support@premium-everyday.com">support@premium-everyday.com</a> atau WhatsApp di +628123456789</p>');
        
        return $message;
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