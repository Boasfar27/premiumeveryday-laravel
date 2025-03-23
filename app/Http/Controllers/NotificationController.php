<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(10);
        $unreadCount = $user->unreadNotifications->count();

        // Cek user agent untuk menentukan view yang digunakan
        $agent = request()->header('User-Agent');
        $isMobile = preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $agent);

        $view = $isMobile 
            ? 'pages.mobile.notifications.index' 
            : 'pages.desktop.notifications.index';

        return view($view, [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount
        ]);
    }

    public function markAsRead(string $id)
    {
        try {
            $notification = Auth::user()->notifications()->findOrFail($id);
            $notification->markAsRead();
            $data = $notification->data;
            
            // Log notifikasi data untuk debugging
            Log::info('Notification data:', ['data' => $data]);
            
            // Tentukan redirect URL berdasarkan tipe notifikasi
            $redirectUrl = $this->determineRedirectUrl($notification);
            
            return redirect($redirectUrl);
        } catch (\Exception $e) {
            Log::error('Notification error: ' . $e->getMessage());
            return redirect()->route('notifications.index')->with('error', 'Terjadi kesalahan saat memproses notifikasi');
        }
    }

    /**
     * Determine the redirect URL based on notification type and data
     */
    private function determineRedirectUrl($notification)
    {
        $data = $notification->data;
        $notifType = $data['notif_type'] ?? 'unknown';
        $role = Auth::user()->role;
        
        Log::info('Processing notification', [
            'type' => $notifType,
            'user_role' => $role,
            'data' => $data
        ]);
        
        // Untuk admin (role=1), gunakan URL admin
        if ($role === 1) {
            switch ($notifType) {
                case 'order_status':
                case 'payment_confirmation':
                    if (isset($data['order_id'])) {
                        // URL Format: /admin/orders/{record}/edit
                        return $this->getAdminUrl('orders', $data['order_id']);
                    }
                    break;
                    
                case 'new_coupon':
                    if (isset($data['coupon_id'])) {
                        return $this->getAdminUrl('coupons', $data['coupon_id']);
                    }
                    break;
                    
                case 'new_product':
                    if (isset($data['product_id'])) {
                        return $this->getAdminUrl('products', $data['product_id']);
                    }
                    break;
            }
            
            // Jika semua tipe notifikasi admin gagal, alihkan ke dashboard admin
            return url('/admin');
        }
        
        // Untuk user reguler (role=0), gunakan URL user
        else {
            switch ($notifType) {
                case 'order_status':
                case 'payment_confirmation':
                    if (isset($data['order_id'])) {
                        return url('/user/payments/' . $data['order_id']);
                    }
                    break;
                    
                case 'new_coupon':
                    return url('/cart?coupon=' . ($data['coupon_code'] ?? ''));
                    
                case 'new_product':
                    if (isset($data['product_slug'])) {
                        // URL produk menggunakan format /products/{slug} sesuai dengan route yang ada
                        Log::info('Navigating to product with slug: ' . $data['product_slug']);
                        return url('/products/' . $data['product_slug']);
                    }
                    break;
            }
        }
        
        // Jika semua gagal, coba gunakan direct link dari data notifikasi
        if (isset($data['link'])) {
            return $data['link'];
        }
        
        // Fallback jika semua gagal
        return route('notifications.index');
    }
    
    /**
     * Get admin URL for resource
     * 
     * @param string $resource Name of the resource (e.g. orders, coupons)
     * @param int $id ID of the resource
     * @return string
     */
    private function getAdminUrl(string $resource, int $id): string
    {
        // Format URL admin dengan benar
        $url = url("/admin/{$resource}/{$id}/edit");
        Log::info("Generated admin URL: {$url}");
        return $url;
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca');
    }
} 