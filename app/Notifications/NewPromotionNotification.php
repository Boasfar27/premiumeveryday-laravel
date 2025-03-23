<?php

namespace App\Notifications;

use App\Models\Promotion;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;

class NewPromotionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Promotion $promotion)
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
            ->subject('Promo Spesial: ' . $this->promotion->name)
            ->greeting('Hai ' . $notifiable->name . '!')
            ->line('Ada promo spesial untuk Anda:')
            ->line($this->promotion->name)
            ->line($this->promotion->description);
            
        if ($this->promotion->url) {
            $email->action('Lihat Promo', url($this->promotion->url));
        }
        
        return $email->line('Jangan lewatkan kesempatan ini!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'promotion_id' => $this->promotion->id,
            'name' => $this->promotion->name,
            'description' => $this->promotion->description,
            'message' => 'Promo Baru: ' . $this->promotion->name,
            'link' => $this->promotion->url ?? '/'
        ];
    }

    /**
     * Send to all users
     */
    public static function sendToAllUsers(Promotion $promotion): void
    {
        User::whereDoesntHave('roles', function($query) {
            $query->where('name', 'admin');
        })->chunk(100, function($users) use ($promotion) {
            foreach ($users as $user) {
                $user->notify(new NewPromotionNotification($promotion));
            }
        });
    }

    /**
     * Notify admin about new promotion
     */
    public static function notifyAdmin(Promotion $promotion): void
    {
        FilamentNotification::make()
            ->title('Promo Baru Dibuat')
            ->icon('heroicon-o-sparkles')
            ->iconColor('success')
            ->body('Promo "' . $promotion->name . '" telah berhasil dibuat dan dikirim ke pengguna')
            ->actions([
                Action::make('view')
                    ->label('Lihat')
                    ->url('/admin/resources/promotions/' . $promotion->id . '/edit'),
            ])
            ->sendToDatabase(User::whereHas('roles', function($query) {
                $query->where('name', 'admin');
            })->get());
    }
} 