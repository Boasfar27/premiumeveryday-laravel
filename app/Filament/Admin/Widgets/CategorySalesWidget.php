<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Category;
use App\Models\DigitalProduct;
use App\Models\OrderItem;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class CategorySalesWidget extends ChartWidget
{
    protected static ?string $heading = 'Penjualan Berdasarkan Kategori';
    protected static ?int $sort = 7;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $maxHeight = '300px';

    // Filter options
    public ?string $filter = 'month';

    protected function getFilters(): ?array
    {
        return [
            'week' => '7 hari terakhir',
            'month' => '30 hari terakhir',
            'quarter' => '3 bulan terakhir',
            'year' => 'Tahun ini',
        ];
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter;
        $startDate = $this->getStartDate($activeFilter);
        
        // Get sales data by category
        $categorySales = $this->getCategorySalesData($startDate);
        
        $labels = $categorySales->pluck('name')->toArray();
        $salesCount = $categorySales->pluck('sales_count')->toArray();
        $revenue = $categorySales->pluck('revenue')->toArray();
        
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Penjualan',
                    'data' => $salesCount,
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                    ],
                    'borderColor' => [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
    
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => "function(context) {
                            let label = context.label || '';
                            let value = context.raw || 0;
                            let sum = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = Math.round((value * 100) / sum);
                            
                            return label + ': ' + value + ' (' + percentage + '%)';
                        }"
                    ]
                ],
            ],
            'responsive' => true,
            'maintainAspectRatio' => false,
        ];
    }
    
    private function getStartDate(string $filter): Carbon
    {
        return match ($filter) {
            'week' => Carbon::now()->subDays(7),
            'month' => Carbon::now()->subDays(30),
            'quarter' => Carbon::now()->subMonths(3),
            'year' => Carbon::now()->startOfYear(),
            default => Carbon::now()->subDays(30),
        };
    }
    
    private function getCategorySalesData(Carbon $startDate)
    {
        // Get categories with their sales count and total revenue
        return Category::select('categories.id', 'categories.name')
            ->selectRaw('COUNT(order_items.id) as sales_count')
            ->selectRaw('SUM(order_items.total) as revenue')
            ->join('digital_products', 'categories.id', '=', 'digital_products.category_id')
            ->join('order_items', function($join) {
                $join->on('digital_products.id', '=', 'order_items.orderable_id')
                    ->where('order_items.orderable_type', '=', DigitalProduct::class);
            })
            ->join('orders', function($join) use ($startDate) {
                $join->on('order_items.order_id', '=', 'orders.id')
                    ->where('orders.status', 'completed')
                    ->where('orders.created_at', '>=', $startDate);
            })
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('sales_count')
            ->get();
    }
} 