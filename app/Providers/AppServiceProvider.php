<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; 

use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Illuminate\Mail\MailManager;
use App\Mail\BrevoTransport;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    // public function register(): void
    // {
    //     //
    // }

    public function register(): void
{

    $this->app->singleton(
        LoginResponse::class,
        \App\Http\Responses\LoginResponse::class
    );
}

 
    public function boot(): void
    {
        app(MailManager::class)->extend('brevo', function ($config) {
            return new BrevoTransport($config['api_key']);
        });

        URL::forceScheme('https');
        
        if (!auth()->check() && request()->path() !== 'login' && !request()->is('livewire/*')) {
            if(request()->is('*products*') || request()->is('*stores*')){
                session(['url.intended' => request()->fullUrl()]); // Store intended URL
            }
        }
    }

}
