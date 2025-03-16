<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Dashboard as BasePage;
use App\Filament\Admin\Widgets\StatsOverview;
use App\Filament\Admin\Widgets\OrdersChart;
use App\Filament\Admin\Widgets\LatestOrders;

class Dashboard extends BasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            OrdersChart::class,
            LatestOrders::class,
        ];
    }
} 