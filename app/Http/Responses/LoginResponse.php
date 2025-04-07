<?php

namespace App\Http\Responses;
 
use App\Filament\Buyer\Resources\FavoriteResource;
use App\Filament\Resources\OrderResource;
use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;
 
class LoginResponse extends \Filament\Http\Responses\Auth\LoginResponse
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        // You can use the Filament facade to get the current panel and check the ID
        if (Filament::getCurrentPanel()->getId() === 'seller') {
            return redirect()->to(session()->get('url.intended', Filament::getUrl())); 
        }
 
        if (Filament::getCurrentPanel()->getId() === 'buyer') {
            return redirect()->to(session()->get('url.intended', Filament::getUrl())); 
        }
 
        return parent::toResponse($request);
    }
}