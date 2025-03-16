<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Orders Chart';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = $this->getOrdersData();

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $data['orders'],
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#36A2EB',
                ],
                [
                    'label' => 'Revenue',
                    'data' => $data['revenue'],
                    'backgroundColor' => '#4BC0C0',
                    'borderColor' => '#4BC0C0',
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    private function getOrdersData(): array
    {
        $labels = [];
        $orders = [];
        $revenue = [];

        // Get data for the last 7 days
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d M');

            // Count orders for this day
            $dailyOrders = Order::whereDate('created_at', $date)->count();
            $orders[] = $dailyOrders;

            // Sum revenue for this day
            $dailyRevenue = Order::whereDate('created_at', $date)
                ->where('status', 'approved')
                ->sum('final_amount') ?? 0;
            $revenue[] = $dailyRevenue / 1000; // Divide by 1000 to make the chart more readable
        }

        return [
            'labels' => $labels,
            'orders' => $orders,
            'revenue' => $revenue,
        ];
    }
} 