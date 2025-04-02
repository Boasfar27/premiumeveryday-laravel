<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Dashboard as BasePage;
use App\Filament\Admin\Widgets\StatsOverview;
use App\Filament\Admin\Widgets\OrdersChart;
use App\Filament\Admin\Widgets\LatestOrders;
use App\Filament\Admin\Widgets\ProductSalesWidget;
use App\Filament\Admin\Widgets\CategorySalesWidget;

class Dashboard extends BasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard Analytics';
    
    protected ?string $heading = 'Dashboard Analytics';
    
    protected ?string $subheading = 'Lihat data penting tentang penjualan dan produk Anda';
    
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
            
            // Charts for revenue and orders
            OrdersChart::class,
            
            // Product sales comparison
            ProductSalesWidget::class,
            
            // Category sales pie chart
            CategorySalesWidget::class,
            
            // Tables for latest data
            LatestOrders::class,
        ];
    }
} 