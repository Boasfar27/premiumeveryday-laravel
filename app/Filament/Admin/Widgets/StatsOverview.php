<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('Total registered users')
                ->descriptionIcon('heroicon-m-user')
                ->color('success'),
            Stat::make('Total Products', Product::count())
                ->description('Products in catalog')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('warning'),
            Stat::make('Total Orders', Order::count())
                ->description('Orders placed')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('danger'),
        ];
    }
} 