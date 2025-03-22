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
                NavigationGroup::make()
                    ->label('Products')
                    ->icon('heroicon-o-shopping-bag')
                    ->items([
                        // Items added automatically for resources with this navigation group
                    ]),
                NavigationGroup::make()
                    ->label('Subscriptions')
                    ->icon('heroicon-o-credit-card')
                    ->items([
                        // Items added automatically for resources with this navigation group
                    ]),
                NavigationGroup::make()
                    ->label('Users')
                    ->icon('heroicon-o-users')
                    ->items([
                        // Items added automatically for resources with this navigation group
                    ]),
                NavigationGroup::make()
                    ->label('Orders')
                    ->icon('heroicon-o-shopping-cart')
                    ->items([
                        // Items added automatically for resources with this navigation group
                    ]),
                NavigationGroup::make()
                    ->label('Content')
                    ->icon('heroicon-o-document-text')
                    ->items([
                        // Items added automatically for resources with this navigation group
                    ]),
                NavigationGroup::make()
                    ->label('Settings')
                    ->icon('heroicon-o-cog')
                    ->items([
                        // Items added automatically for resources with this navigation group
                    ]),
            ])
            ->databaseNotifications()
            ->globalSearch();
    }
}
