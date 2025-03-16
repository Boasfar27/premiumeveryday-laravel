<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Dashboard as BasePage;
use App\Filament\Admin\Widgets\StatsOverview;
use App\Filament\Admin\Widgets\OrdersChart;
use App\Filament\Admin\Widgets\LatestOrders;

class Dashboard extends BasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    /**
     * Override the default widgets to prevent duplication and define custom layout
     * 
     * This replaces both getHeaderWidgets() and getFooterWidgets() with a single method
     * that controls all widgets displayed on the dashboard.
     */
    public function getWidgets(): array
    {
        return [
            // Stats widgets at the top
            StatsOverview::class,
            
            // Charts and tables below
            OrdersChart::class,
            LatestOrders::class,
        ];
    }
} 