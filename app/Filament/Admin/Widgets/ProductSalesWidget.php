<?php

namespace App\Filament\Admin\Widgets;

use App\Models\DigitalProduct;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ProductSalesWidget extends ChartWidget
{
    protected static ?string $heading = 'Perbandingan Penjualan Produk';
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $maxHeight = '300px';

    // Filter options
    public ?string $filter = 'week';

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
        
        // Get date range based on filter
        $startDate = $this->getStartDate($activeFilter);
        
        // Get top selling products (max 5)
        $products = $this->getTopSellingProducts($startDate);
        
        // Set labels (product names)
        $labels = $products->pluck('name')->toArray();
        
        // Set data
        $productIds = $products->pluck('id')->toArray();
        $productsData = [];
        
        // Sales count data
        $salesCounts = $this->getSalesCountData($productIds, $startDate);
        $productsData[] = [
            'label' => 'Jumlah Penjualan',
            'data' => $salesCounts,
            'backgroundColor' => 'rgba(59, 130, 246, 0.8)', // Blue
        ];
        
        // Revenue data
        $revenueData = $this->getRevenueData($productIds, $startDate);
        $productsData[] = [
            'label' => 'Pendapatan (dalam ribuan)',
            'data' => $revenueData,
            'backgroundColor' => 'rgba(16, 185, 129, 0.8)', // Green
        ];
        
        return [
            'datasets' => $productsData,
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
    
    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => "function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                if (context.dataset.label === 'Pendapatan (dalam ribuan)') {
                                    label += new Intl.NumberFormat('id-ID', { 
                                        style: 'currency', 
                                        currency: 'IDR',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: 0
                                    }).format(context.parsed.y * 1000);
                                } else {
                                    label += context.parsed.y;
                                }
                            }
                            return label;
                        }"
                    ]
                ],
            ],
        ];
    }
    
    private function getStartDate(string $filter): Carbon
    {
        return match ($filter) {
            'week' => Carbon::now()->subDays(7),
            'month' => Carbon::now()->subDays(30),
            'quarter' => Carbon::now()->subMonths(3),
            'year' => Carbon::now()->startOfYear(),
            default => Carbon::now()->subDays(7),
        };
    }
    
    private function getTopSellingProducts(Carbon $startDate): \Illuminate\Support\Collection
    {
        return DigitalProduct::select('digital_products.id', 'digital_products.name')
            ->join('order_items', function($join) {
                $join->on('digital_products.id', '=', 'order_items.orderable_id')
                    ->where('order_items.orderable_type', '=', DigitalProduct::class);
            })
            ->join('orders', function($join) use ($startDate) {
                $join->on('order_items.order_id', '=', 'orders.id')
                    ->where('orders.status', 'completed')
                    ->where('orders.created_at', '>=', $startDate);
            })
            ->groupBy('digital_products.id', 'digital_products.name')
            ->orderByRaw('COUNT(order_items.id) DESC')
            ->limit(5)
            ->get();
    }
    
    private function getSalesCountData(array $productIds, Carbon $startDate): array
    {
        $salesData = [];
        
        foreach ($productIds as $productId) {
            $salesCount = OrderItem::where('orderable_id', $productId)
                ->where('orderable_type', DigitalProduct::class)
                ->whereHas('order', function ($query) use ($startDate) {
                    $query->where('status', 'completed')
                          ->where('created_at', '>=', $startDate);
                })
                ->count();
                
            $salesData[] = $salesCount;
        }
        
        return $salesData;
    }
    
    private function getRevenueData(array $productIds, Carbon $startDate): array
    {
        $revenueData = [];
        
        foreach ($productIds as $productId) {
            $revenue = OrderItem::where('orderable_id', $productId)
                ->where('orderable_type', DigitalProduct::class)
                ->whereHas('order', function ($query) use ($startDate) {
                    $query->where('status', 'completed')
                          ->where('created_at', '>=', $startDate);
                })
                ->sum('price') / 1000; // Divide by 1000 to make the chart more readable
                
            $revenueData[] = $revenue;
        }
        
        return $revenueData;
    }
} 