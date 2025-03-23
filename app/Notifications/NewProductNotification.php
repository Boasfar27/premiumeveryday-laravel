<?php

namespace App\Notifications;

use App\Models\Product;
use App\Models\DigitalProduct;
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

    /**
     * @param Product|DigitalProduct $product
     */
    public function __construct(public $product)
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
        // Tentukan URL berdasarkan tipe produk
        $productUrl = $this->getProductUrl();
        
        return (new MailMessage)
            ->subject('Produk Baru: ' . $this->product->name)
            ->greeting('Hai ' . $notifiable->name . '!')
            ->line('Kami baru saja menambahkan produk baru yang mungkin Anda minati:')
            ->line($this->product->name)
            ->line(strip_tags($this->product->short_description))
            ->action('Lihat Produk', $productUrl)
            ->line('Terima kasih telah berbelanja di Premium Everyday!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        // Gunakan route products.show
        try {
            // Parameter harus sesuai dengan route definition
            $slug = $this->product->slug;
            $link = route('products.show', ['product' => $slug]);
        } catch (\Exception $e) {
            // Fallback jika route tidak ditemukan
            $link = url('/products/' . $this->product->slug);
        }
        
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'message' => 'Produk Baru: ' . $this->product->name,
            'link' => $link,
            'route_name' => 'products.show',
            'route_params' => ['product' => $this->product->slug],
            'notif_type' => 'new_product',
            // Data tambahan yang mungkin diperlukan untuk halaman detail
            'product_slug' => $this->product->slug
        ];
    }

    /**
     * Get the product URL based on product type
     */
    private function getProductUrl(): string
    {
        // Gunakan route untuk mendapatkan URL yang valid
        try {
            return route('products.show', ['product' => $this->product->slug]);
        } catch (\Exception $e) {
            // Fallback jika route tidak ditemukan
            return url('/products/' . $this->product->slug);
        }
    }
    
    /**
     * Send to all users
     * 
     * @param Product|DigitalProduct $product
     */
    public static function sendToAllUsers($product): void
    {
        User::where('role', 0)->chunk(100, function($users) use ($product) {
            foreach ($users as $user) {
                $user->notify(new NewProductNotification($product));
            }
        });
    }

    /**
     * Notify admin about new product
     * 
     * @param Product|DigitalProduct $product
     */
    public static function notifyAdmin($product): void
    {
        // Tentukan URL admin berdasarkan tipe produk
        $adminUrl = self::getAdminUrl($product);
        
        FilamentNotification::make()
            ->title('Produk Baru Ditambahkan')
            ->icon('heroicon-o-shopping-bag')
            ->iconColor('success')
            ->body('Produk "' . $product->name . '" telah berhasil ditambahkan')
            ->actions([
                Action::make('view')
                    ->label('Lihat')
                    ->url($adminUrl),
            ])
            ->sendToDatabase(User::where('role', 1)->get());
    }
    
    /**
     * Get admin URL based on product type
     * 
     * @param Product|DigitalProduct $product
     * @return string
     */
    private static function getAdminUrl($product): string
    {
        if ($product instanceof DigitalProduct) {
            try {
                return route('filament.admin.resources.digital-products.edit', ['record' => $product->id]);
            } catch (\Exception $e) {
                return '/admin/digital-products/' . $product->id . '/edit';
            }
        }
        
        try {
            return route('filament.admin.resources.products.edit', ['record' => $product->id]);
        } catch (\Exception $e) {
            return '/admin/products/' . $product->id . '/edit';
        }
    }
} 