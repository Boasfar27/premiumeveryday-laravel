<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Analisis Penjualan';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $maxHeight = '300px';

    // Filter options
    public ?string $filter = 'week';

    protected function getFilters(): ?array
    {
        return [
            'week' => 'Last 7 days',
            'month' => 'Last 30 days',
            'quarter' => 'Last 3 months',
            'year' => 'This year',
        ];
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter;
        $data = $this->getOrdersData($activeFilter);

        return [
            'datasets' => [
                [
                    'label' => 'Pesanan',
                    'data' => $data['orders'],
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)', // Light blue background
                    'borderColor' => 'rgba(59, 130, 246, 0.8)', // Blue border
                    'borderWidth' => 2,
                    'tension' => 0.3, // Smooth curve
                    'pointBackgroundColor' => 'rgba(59, 130, 246, 1)',
                    'pointBorderColor' => '#ffffff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 4,
                    'fill' => true,
                ],
                [
                    'label' => 'Pendapatan (dalam ribuan)',
                    'data' => $data['revenue'],
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)', // Light green background
                    'borderColor' => 'rgba(16, 185, 129, 0.8)', // Green border
                    'borderWidth' => 2,
                    'tension' => 0.3, // Smooth curve
                    'pointBackgroundColor' => 'rgba(16, 185, 129, 1)',
                    'pointBorderColor' => '#ffffff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 4,
                    'fill' => true,
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
            'elements' => [
                'line' => [
                    'tension' => 0.1, // Slight curve for line charts
                ],
                'point' => [
                    'radius' => 3,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    private function getOrdersData(string $filter): array
    {
        $labels = [];
        $orders = [];
        $revenue = [];

        switch ($filter) {
            case 'week':
                // Last 7 days
                for ($i = 6; $i >= 0; $i--) {
                    $date = Carbon::now()->subDays($i);
                    $labels[] = $date->format('d M');

                    // Count orders for this day
                    $dailyOrders = Order::whereDate('created_at', $date)->count();
                    $orders[] = $dailyOrders;

                    // Sum revenue for this day
                    $dailyRevenue = Order::whereDate('created_at', $date)
                        ->where('payment_status', 'paid')
                        ->sum('total') ?? 0;
                    $revenue[] = $dailyRevenue / 1000; // Divide by 1000 to make the chart more readable
                }
                break;

            case 'month':
                // Last 30 days grouped by 3 days
                for ($i = 9; $i >= 0; $i--) {
                    $startDate = Carbon::now()->subDays($i * 3 + 2);
                    $endDate = Carbon::now()->subDays($i * 3);
                    
                    $labels[] = $startDate->format('d M') . ' - ' . $endDate->format('d M');

                    // Count orders for this period
                    $periodOrders = Order::whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])->count();
                    $orders[] = $periodOrders;

                    // Sum revenue for this period
                    $periodRevenue = Order::whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
                        ->where('payment_status', 'paid')
                        ->sum('total') ?? 0;
                    $revenue[] = $periodRevenue / 1000;
                }
                break;

            case 'quarter':
                // Last 3 months by week
                for ($i = 11; $i >= 0; $i--) {
                    $startDate = Carbon::now()->subWeeks($i);
                    $endDate = Carbon::now()->subWeeks($i)->endOfWeek();
                    
                    $labels[] = $startDate->format('d M');

                    // Count orders for this week
                    $weekOrders = Order::whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])->count();
                    $orders[] = $weekOrders;

                    // Sum revenue for this week
                    $weekRevenue = Order::whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
                        ->where('payment_status', 'paid')
                        ->sum('total') ?? 0;
                    $revenue[] = $weekRevenue / 1000;
                }
                break;

            case 'year':
                // This year by month
                for ($i = 0; $i < 12; $i++) {
                    $date = Carbon::now()->startOfYear()->addMonths($i);
                    $labels[] = $date->format('M');

                    // Count orders for this month
                    $monthOrders = Order::whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month)
                        ->count();
                    $orders[] = $monthOrders;

                    // Sum revenue for this month
                    $monthRevenue = Order::whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month)
                        ->where('payment_status', 'paid')
                        ->sum('total') ?? 0;
                    $revenue[] = $monthRevenue / 1000;
                }
                break;
        }

        return [
            'labels' => $labels,
            'orders' => $orders,
            'revenue' => $revenue,
        ];
    }

    // New method to render an additional chart showing order status breakdown
    public function extraCharts(): array
    {
        // Get counts of each order status
        $pendingOrders = Order::where('status', 'pending')->count();
        $approvedOrders = Order::where('status', 'approved')->count();
        $rejectedOrders = Order::where('status', 'rejected')->count();
        
        return [
            'orderStatusChart' => [
                'type' => 'doughnut',
                'data' => [
                    'labels' => ['Menunggu', 'Disetujui', 'Ditolak'],
                    'datasets' => [
                        [
                            'label' => 'Status Pesanan',
                            'data' => [$pendingOrders, $approvedOrders, $rejectedOrders],
                            'backgroundColor' => [
                                '#FCD34D', // yellow for pending
                                '#10B981', // green for approved
                                '#EF4444', // red for rejected
                            ],
                            'borderColor' => '#FFFFFF',
                            'borderWidth' => 2,
                        ],
                    ],
                ],
                'options' => [
                    'responsive' => true,
                    'plugins' => [
                        'legend' => [
                            'position' => 'bottom',
                        ],
                        'title' => [
                            'display' => true,
                            'text' => 'Distribusi Status Pesanan',
                        ],
                    ],
                ],
            ],
        ];
    }
} 