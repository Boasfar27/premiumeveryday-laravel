<?php

namespace App\Filament\Admin\Widgets;

use App\Models\DigitalProductLicense;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LicenseActivationWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    protected static ?string $pollingInterval = '300s';
    protected int|string|array $columnSpan = 'full';
    
    protected function getHeading(): string
    {
        return 'Statistik Aktivasi Lisensi';
    }
    
    protected function getColumns(): int
    {
        return 4;
    }
    
    protected function getStats(): array
    {
        // Total licenses
        $totalLicenses = DigitalProductLicense::count();
        
        // Activated licenses
        $activatedLicenses = DigitalProductLicense::whereNotNull('activated_at')->count();
        
        // Activation rate
        $activationRate = $totalLicenses > 0 
            ? round(($activatedLicenses / $totalLicenses) * 100, 1) . '%' 
            : '0%';
            
        // Today's activations
        $todayActivations = DigitalProductLicense::whereDate('activated_at', Carbon::today())->count();
        
        // This week's activations
        $thisWeekActivations = DigitalProductLicense::whereBetween('activated_at', [
            Carbon::now()->startOfWeek(), 
            Carbon::now()->endOfWeek()
        ])->count();
        
        // Never activated licenses
        $neverActivated = $totalLicenses - $activatedLicenses;
        
        // Recent activations (7 days trend)
        $recentActivations = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = DigitalProductLicense::whereDate('activated_at', $date)->count();
            $recentActivations[] = $count;
        }
        
        return [
            Stat::make('Total Lisensi', number_format($totalLicenses, 0, ',', '.'))
                ->description('Diterbitkan untuk pengguna')
                ->descriptionIcon('heroicon-m-key')
                ->color('primary'),
                
            Stat::make('Lisensi Teraktivasi', number_format($activatedLicenses, 0, ',', '.'))
                ->description('Tingkat aktivasi: ' . $activationRate)
                ->descriptionIcon('heroicon-m-check-circle')
                ->chart($recentActivations)
                ->color('success'),
                
            Stat::make('Aktivasi Hari Ini', number_format($todayActivations, 0, ',', '.'))
                ->description('Minggu ini: ' . number_format($thisWeekActivations, 0, ',', '.'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning'),
                
            Stat::make('Belum Diaktivasi', number_format($neverActivated, 0, ',', '.'))
                ->description('Menunggu aktivasi')
                ->descriptionIcon('heroicon-m-clock')
                ->color($neverActivated > $activatedLicenses ? 'danger' : 'gray'),
        ];
    }
} 