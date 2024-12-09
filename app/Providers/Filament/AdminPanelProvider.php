<?php

namespace App\Providers\Filament;

use App\Filament\Pages\auth\Register;
use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use BezhanSalleh\FilamentShield\Resources\RoleResource;
use Datlechin\FilamentMenuBuilder\FilamentMenuBuilderPlugin;
use Datlechin\FilamentMenuBuilder\Models\Menu;
use Datlechin\FilamentMenuBuilder\Resources\MenuResource;
use Filament\FontProviders\GoogleFontProvider;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets;
use Hasnayeen\Themes\Http\Middleware\SetTheme;
use Hasnayeen\Themes\ThemesPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentGeneralSettings\FilamentGeneralSettingsPlugin;
use Joaopaulolndev\FilamentGeneralSettings\Pages\GeneralSettingsPage;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;
use Z3d0X\FilamentLogger\Resources\ActivityResource;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->registration(Register::class)
            ->passwordReset()
            ->font('Poppins', provider: GoogleFontProvider::class)
            ->sidebarCollapsibleOnDesktop(true)
            ->brandLogo(asset('images/logo.png'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->resources([
                config('filament-logger.activity_resource')
            ])
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder
                    ->items([
                        ...Dashboard::getNavigationItems()
                    ])
                    ->groups([
                        NavigationGroup::make('User Management')
                            ->icon('heroicon-o-users')
                            ->items([
                                NavigationItem::make('Roles')
                                    ->url(fn(): string => RoleResource::getUrl())
                                    ->isActiveWhen(fn(): bool => request()->routeIs('filament.admin.resources.shield.roles.*'))
                                    ->visible(fn(): bool => auth()->user()->can('view', Role::class)),
                                NavigationItem::make('Users')
                                    ->url(fn(): string => UserResource::getUrl())
                                    ->isActiveWhen(fn(): bool => request()->routeIs('filament.admin.resources.users.*'))
                                    ->visible(fn(): bool => auth()->user()->can('view', User::class)),
                                NavigationItem::make('Activity')
                                    ->url(fn(): string => ActivityResource::getUrl())
                                    ->isActiveWhen(fn(): bool => request()->routeIs('filament.admin.resources.activity-logs.*'))
                                    ->visible(fn(): bool => auth()->user()->can('view', Activity::class))
                            ]),
                        NavigationGroup::make('Settings')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->items([
                                NavigationItem::make('Menu')
                                    ->url(fn(): string => MenuResource::getUrl())
                                    ->isActiveWhen(fn(): bool => request()->routeIs('filament.admin.resources.menus.*'))
                                    ->visible(fn(): bool => auth()->user()->can('view', Menu::class)),
                                NavigationItem::make('General')
                                    ->url(fn(): string => GeneralSettingsPage::getUrl())
                                    ->isActiveWhen(fn(): bool => request()->routeIs('filament.admin.pages.general-settings-page'))
                                    ->visible(fn(): bool => auth()->user()?->hasRole('admin'))
                            ]),
                    ]);
            })
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
                SetTheme::class
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
                ThemesPlugin::make(),
                FilamentMenuBuilderPlugin::make(),
                FilamentGeneralSettingsPlugin::make()
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
