<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Admin\Pages\Dashboard;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->registration(false)
            ->passwordReset(false)
            ->emailVerification(false)
            ->profile(false)
            ->homeUrl('/')
            ->brandLogo(asset('images/logo.webp'))
            ->brandLogoHeight('40px')
            ->brandName('Premium Everyday')
            ->sidebarCollapsibleOnDesktop()
            ->colors([
                'primary' => Color::Rose,
                'gray' => Color::Slate,
                'danger' => Color::Rose,
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->font('Inter')
            ->favicon(asset('images/favicon.ico'))
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->navigationGroups([
                // Dashboard Group
                NavigationGroup::make()
                    ->label('Analytics')
                    ->icon('heroicon-o-chart-bar')
                    ->collapsed(),
                    
                // Katalog Produk
                NavigationGroup::make()
                    ->label('Katalog')
                    ->icon('heroicon-o-shopping-bag')
                    ->collapsible(),
                
                // Penjualan dan Pesanan
                NavigationGroup::make()
                    ->label('Penjualan')
                    ->icon('heroicon-o-shopping-cart')
                    ->collapsible(),
                
                // Langganan
                NavigationGroup::make()
                    ->label('Langganan')
                    ->icon('heroicon-o-credit-card')
                    ->collapsible(),
                
                // Pengguna
                NavigationGroup::make()
                    ->label('Pengguna')
                    ->icon('heroicon-o-users')
                    ->collapsible(),
                
                // Konten Website
                NavigationGroup::make()
                    ->label('Konten')
                    ->icon('heroicon-o-document-text')
                    ->collapsible(),
                
                // Pengaturan
                NavigationGroup::make()
                    ->label('Pengaturan')
                    ->icon('heroicon-o-cog')
                    ->collapsible(),
            ])
            ->databaseNotifications()
            ->globalSearch(true)
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->globalSearchDebounce(800);
    }
}
