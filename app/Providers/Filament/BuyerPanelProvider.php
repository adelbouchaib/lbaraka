<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

use JaOcero\FilaChat\FilaChatPlugin;
use Filament\Facades\Filament; // <-- Correct Import for Filament Facade
use Filament\Navigation\MenuItem;
use App\Filament\Buyer\Pages\Settings;

use Filament\Support\Facades\FilamentColor;
use App\Filament\Buyer\Pages\Auth\Register;
use Filament\View\PanelsRenderHook;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use App\Http\Responses\LoginResponse;
use Illuminate\Support\Facades\Session;


class BuyerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('buyer')
            ->path('')
            ->login()
            ->registration(Register::class) 
            ->passwordReset()
            ->emailVerification()
            ->colors([
                'primary' => '#0071f5',
                'secondary' => '#fbbc04',
            ])
            ->viteTheme('resources/css/filament/buyer/theme.css')
            ->discoverResources(in: app_path('Filament/Buyer/Resources'), for: 'App\\Filament\\Buyer\\Resources')
            ->discoverPages(in: app_path('Filament/Buyer/Pages'), for: 'App\\Filament\\Buyer\\Pages')
            ->pages([
                // Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Buyer/Widgets'), for: 'App\\Filament\\Buyer\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
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
            ->renderHook( 
                'panels::auth.login.form.after',
                fn () => view('auth.socialite.google')
            )
            ->brandLogo(fn () => view('components.custom-logo'))
            ->favicon(fn () => asset('images/icon.png'))
            ->darkMode(false)
            ->userMenuItems([
                MenuItem::make()
                    ->label('Settings')
                    ->url(fn (): string => Settings::getUrl()) // ✅ Link to settings
                    ->icon('heroicon-o-cog-6-tooth'),
                
            ])

            // ->renderHook(PanelsRenderHook::SIDEBAR_FOOTER, function () {
            //     return view('filament.buyer.sidebar-footer');
            // })
            ->plugins([
                FilaChatPlugin::make(),

            ]);
    }

    
   

}
