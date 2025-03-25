<?php

namespace App\Filament\Admin\Widgets;

use App\Models\DigitalProduct;
use App\Models\Order;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\Setting;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    
    // Refresh interval in seconds (5 minutes)
    protected static ?string $pollingInterval = '300s';
    
    protected int|string|array $columnSpan = 'full';
    
    protected function getHeading(): string
    {
        return 'Statistik Platform';
    }
    
    protected function getColumns(): int
    {
        return 4;
    }
    
    protected function getStats(): array
    {
        // Get currency symbol from settings
        $currencySymbol = Setting::get('currency_symbol', 'Rp');
        
        // Get this month's revenue
        $thisMonthRevenue = Order::where('payment_status', 'paid')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total');
            
        // Get last month's revenue for comparison
        $lastMonthRevenue = Order::where('payment_status', 'paid')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('total');
            
        // Calculate percentage change
        $revenueChange = $lastMonthRevenue > 0 
            ? round(($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue * 100, 1)
            : 100;
            
        // Get active subscriptions count
        $activeSubscriptions = UserSubscription::where('status', 'active')
            ->where('expires_at', '>', now())
            ->count();
            
        // Get expiring soon subscriptions (next 7 days)
        $expiringSoon = UserSubscription::where('status', 'active')
            ->whereBetween('expires_at', [now(), now()->addDays(7)])
            ->count();
            
        // Get top selling product
        $topProduct = DigitalProduct::select('digital_products.name', DB::raw('COUNT(order_items.id) as sales_count'))
            ->join('order_items', function($join) {
                $join->on('digital_products.id', '=', 'order_items.orderable_id')
                    ->where('order_items.orderable_type', '=', DigitalProduct::class);
            })
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'paid')
            ->groupBy('digital_products.id', 'digital_products.name')
            ->orderBy('sales_count', 'desc')
            ->first();
        
        return [
            Stat::make('Total Pengguna', User::count())
                ->description('Terdaftar di platform')
                ->descriptionIcon('heroicon-m-user')
                ->chart(User::selectRaw('COUNT(*) as count, DATE(created_at) as date')
                    ->where('created_at', '>=', now()->subDays(30))
                    ->groupBy('date')
                    ->orderBy('date')
                    ->pluck('count')
                    ->toArray())
                ->color('success'),
                
            Stat::make('Produk Digital', DigitalProduct::where('is_active', true)->count())
                ->description('Produk Aktif')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->chart([4, 8, 12, 16, 18, 19, DigitalProduct::where('is_active', true)->count()])
                ->color('warning'),
                
            Stat::make('Langganan Aktif', $activeSubscriptions)
                ->description($expiringSoon > 0 ? $expiringSoon . ' akan berakhir dalam 7 hari' : 'Semua dalam periode aktif')
                ->descriptionIcon($expiringSoon > 0 ? 'heroicon-m-clock' : 'heroicon-m-check-badge')
                ->color($expiringSoon > 0 ? 'warning' : 'primary'),
                
            Stat::make('Pendapatan Bulan Ini', $currencySymbol . ' ' . number_format($thisMonthRevenue, 0, ',', '.'))
                ->description($revenueChange >= 0 
                    ? "Naik {$revenueChange}% dari bulan lalu" 
                    : "Turun " . abs($revenueChange) . "% dari bulan lalu")
                ->descriptionIcon($revenueChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueChange >= 0 ? 'success' : 'danger'),
                
            Stat::make('Total Pesanan', Order::count())
                ->description(Order::where('payment_status', 'paid')->count() . ' pesanan selesai')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->chart(Order::selectRaw('COUNT(*) as count, DATE(created_at) as date')
                    ->where('created_at', '>=', now()->subDays(30))
                    ->groupBy('date')
                    ->orderBy('date')
                    ->pluck('count')
                    ->toArray())
                ->color('primary'),
                
            Stat::make('Paket Langganan', SubscriptionPlan::where('is_active', true)->count())
                ->description('Tersedia untuk dijual')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('success'),
                
            Stat::make('Produk Terlaris', $topProduct ? $topProduct->name : 'Belum ada penjualan')
                ->description($topProduct ? $topProduct->sales_count . ' penjualan' : 'Belum ada data')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('warning'),
                
            Stat::make('Tingkat Konversi', Order::count() > 0 
                ? round((Order::where('payment_status', 'paid')->count() / Order::count()) * 100, 1) . '%'
                : '0%')
                ->description('Pesanan lunas/total pesanan')
                ->descriptionIcon('heroicon-m-presentation-chart-line')
                ->color('success'),
        ];
    }
} 