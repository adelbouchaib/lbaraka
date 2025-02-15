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
use App\Filament\Resources\Auth\Register;

use JaOcero\FilaChat\FilaChatPlugin;
use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use App\Models\FilachatMessage;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use App\Models\Order;
use App\Filament\Pages\Dashboard;
use Filament\Navigation\MenuItem;

use App\Filament\Pages\Settings;
use App\Filament\Pages\Ranking;

use Filament\Navigation\NavigationItem;


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
            ->colors([
                'primary' => Color::Amber,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                // Pages\Dashboard::class,
                // Pages\Settings::class, // ✅ Add the settings page

            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\AccountOverview::class,
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
            ->userMenuItems([
                MenuItem::make()
                    ->label('Ranking')
                    ->url(fn (): string => Ranking::getUrl()) // ✅ Link to settings
                    ->icon('heroicon-o-trophy'),
                MenuItem::make()
                    ->label('Settings')
                    ->url(fn (): string => Settings::getUrl()) // ✅ Link to settings
                    ->icon('heroicon-o-cog-6-tooth'),
                
            ])
            ->plugins([
                FilaChatPlugin::make()
            ]);
    }

    public function boot()
    {

        // GLOBAL_SEARCH_AFTER

        Filament::serving(function () {
            if (auth()->check()) {
                $user = auth()->user();
                if($user->role !== "seller"){
                    FilamentView::registerRenderHook(
                        PanelsRenderHook::GLOBAL_SEARCH_BEFORE ,
                        function () {
                           

                            // Render the component with the data
                            return Blade::renderComponent(
                                new \App\View\Components\TopbarComponent()
                            );
                        }
                    ); 
                }
               
            }
        });

            
        
       
    }
}
