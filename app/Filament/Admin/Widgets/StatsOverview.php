<?php

namespace App\Filament\Admin\Widgets;

use App\Models\DigitalProduct;
use App\Models\Order;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getHeading(): string
    {
        return 'Overview';
    }
    
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('Total registered users')
                ->descriptionIcon('heroicon-m-user')
                ->color('success'),
            Stat::make('Digital Products', DigitalProduct::where('is_active', true)->count())
                ->description('Active products')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('warning'),
            Stat::make('Subscription Plans', SubscriptionPlan::where('is_active', true)->count())
                ->description('Active plans')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('primary'),
            Stat::make('Total Orders', Order::count())
                ->description('Orders placed')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('danger'),
        ];
    }
} 