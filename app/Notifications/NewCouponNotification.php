<?php

namespace App\Notifications;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Support\Facades\Log;

class NewCouponNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Coupon $coupon)
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
        $email = (new MailMessage)
            ->subject('Kode Kupon Baru: ' . $this->coupon->code)
            ->greeting('Hai ' . $notifiable->name . '!')
            ->line('Ada kode kupon baru untuk Anda:')
            ->line('Kode: ' . $this->coupon->code);
            
        if ($this->coupon->type === 'percentage') {
            $email->line('Diskon: ' . $this->coupon->discount . '%');
        } else {
            $email->line('Diskon: Rp ' . number_format($this->coupon->discount, 0, ',', '.'));
        }
        
        if ($this->coupon->expires_at) {
            $email->line('Berlaku Hingga: ' . $this->coupon->expires_at->format('d M Y'));
        }
        
        if ($this->coupon->description) {
            $email->line('Deskripsi: ' . $this->coupon->description);
        }
        
        // Gunakan route untuk cart
        try {
            $cartUrl = route('cart.index', ['coupon' => $this->coupon->code]);
        } catch (\Exception $e) {
            // Fallback URL
            $cartUrl = url('/cart?coupon=' . $this->coupon->code);
        }
        
        $email->action('Gunakan Kupon', $cartUrl);
        
        return $email->line('Terima kasih telah berbelanja di Premium Everyday!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        // Gunakan route cart.index dengan parameter
        try {
            $link = route('cart.index', ['coupon' => $this->coupon->code]);
        } catch (\Exception $e) {
            // Fallback jika route tidak ditemukan
            $link = url('/cart?coupon=' . $this->coupon->code);
        }
        
        return [
            'coupon_id' => $this->coupon->id,
            'coupon_code' => $this->coupon->code,
            'discount_type' => $this->coupon->type,
            'discount_value' => $this->coupon->discount,
            'message' => 'Kode kupon baru: ' . $this->coupon->code,
            'link' => $link,
            'route_name' => 'cart.index',
            'route_params' => ['coupon' => $this->coupon->code],
            'notif_type' => 'new_coupon'
        ];
    }

    /**
     * Send to all users
     */
    public static function sendToAllUsers(Coupon $coupon): void
    {
        User::where('role', 0)->chunk(100, function($users) use ($coupon) {
            foreach ($users as $user) {
                $user->notify(new NewCouponNotification($coupon));
            }
        });
    }

    /**
     * Notify admin about new coupon
     */
    public static function notifyAdmin(Coupon $coupon): void
    {
        // Gunakan route untuk URL admin
        try {
            $adminUrl = route('filament.admin.resources.coupons.edit', ['record' => $coupon->id]);
        } catch (\Exception $e) {
            // Fallback jika route tidak ditemukan
            Log::error('Admin coupon URL error: ' . $e->getMessage());
            $adminUrl = '/admin/coupons/' . $coupon->id . '/edit';
        }
        
        FilamentNotification::make()
            ->title('Kupon Baru Dibuat')
            ->icon('heroicon-o-ticket')
            ->iconColor('success')
            ->body('Kupon "' . $coupon->code . '" telah berhasil dibuat')
            ->actions([
                Action::make('view')
                    ->label('Lihat')
                    ->url($adminUrl),
            ])
            ->sendToDatabase(User::where('role', 1)->get());
    }
} 