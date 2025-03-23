<?php

namespace App\Notifications;

use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;

class NewProductNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Product $product)
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
            ->subject('Produk Baru: ' . $this->product->name)
            ->greeting('Hai ' . $notifiable->name . '!')
            ->line('Kami baru saja menambahkan produk baru yang mungkin Anda minati:')
            ->line($this->product->name)
            ->line(strip_tags($this->product->short_description))
            ->action('Lihat Produk', url('/products/' . $this->product->slug))
            ->line('Terima kasih telah berbelanja di Premium Everyday!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'message' => 'Produk Baru: ' . $this->product->name,
            'link' => '/products/' . $this->product->slug
        ];
    }

    /**
     * Send to all users
     */
    public static function sendToAllUsers(Product $product): void
    {
        User::whereDoesntHave('roles', function($query) {
            $query->where('name', 'admin');
        })->chunk(100, function($users) use ($product) {
            foreach ($users as $user) {
                $user->notify(new NewProductNotification($product));
            }
        });
    }

    /**
     * Notify admin about new product
     */
    public static function notifyAdmin(Product $product): void
    {
        FilamentNotification::make()
            ->title('Produk Baru Ditambahkan')
            ->icon('heroicon-o-shopping-bag')
            ->iconColor('success')
            ->body('Produk "' . $product->name . '" telah berhasil ditambahkan')
            ->actions([
                Action::make('view')
                    ->label('Lihat')
                    ->url('/admin/resources/products/' . $product->id . '/edit'),
            ])
            ->sendToDatabase(User::whereHas('roles', function($query) {
                $query->where('name', 'admin');
            })->get());
    }
} 