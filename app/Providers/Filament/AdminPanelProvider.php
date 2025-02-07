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
                Pages\Dashboard::class,
            ])
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
            ])
            ->authMiddleware([
                Authenticate::class,
               
            ])
            ->plugins([
                FilaChatPlugin::make()
            ]);
    }

    public function boot()
    {
        Filament::serving(function () {
            // Get unread message count or any dynamic data
            $unreadCount = FilachatMessage::where(function($query) {
                $query->where('receiverable_id', auth()->id())  // Check receiver
                    ->whereNull('last_read_at');
            })
            ->orWhere(function($query) {
                $query->where('senderable_id', auth()->id())  // Check sender
                    ->whereNull('last_read_at');
            })
            ->count();
        

            // Dynamically modify the navigation label
            config([
                'filachat.navigation_label' => 'Chat (' . $unreadCount . ')',
            ]);
        });
    }
}
