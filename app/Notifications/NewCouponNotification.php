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
        
        return $email->action('Gunakan Sekarang', url('/products'))
            ->line('Jangan lewatkan kesempatan ini!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        $message = $this->coupon->type === 'percentage' 
            ? 'Diskon ' . $this->coupon->discount . '%' 
            : 'Diskon Rp ' . number_format($this->coupon->discount, 0, ',', '.');
            
        return [
            'coupon_id' => $this->coupon->id,
            'code' => $this->coupon->code,
            'discount' => $this->coupon->discount,
            'message' => 'Kode Kupon Baru: ' . $this->coupon->code . ' - ' . $message,
            'link' => '/products'
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
        FilamentNotification::make()
            ->title('Kupon Baru Dibuat')
            ->icon('heroicon-o-ticket')
            ->iconColor('success')
            ->body('Kupon "' . $coupon->code . '" telah berhasil dibuat')
            ->actions([
                Action::make('view')
                    ->label('Lihat')
                    ->url('/admin/resources/coupons/' . $coupon->id . '/edit'),
            ])
            ->sendToDatabase(User::where('role', 1)->get());
    }
} 