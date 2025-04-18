<?php

namespace App\Http\Controllers;
 
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
 
class SocialiteController extends Controller
{
    public function redirect(string $provider)
    {
        $this->validateProvider($provider);
 
        return Socialite::driver($provider)->redirect();
    }
 
    public function callback(string $provider)
    {
        $this->validateProvider($provider);
 
        $response = Socialite::driver($provider)->user();
 
        $user = User::firstWhere(['email' => $response->getEmail()]);
 
        if ($user) {
            $user->update([$provider . '_id' => $response->getId()]);
        } else {
            session([
                'social_user' => [
                    'provider' => $provider,
                    'id'       => $response->getId(),
                    'name'     => $response->getName(),
                    'email'    => $response->getEmail(),
                ]
            ]);
    
            return redirect()->route('complete.profile');
        }
 
        auth()->login($user);
 
        return redirect()->intended(route('filament.buyer.pages.dashboard'));
    }
 
    protected function validateProvider(string $provider): array
    {
        return validator(
            ['provider' => $provider],
            ['provider' => 'in:google']
        )->validate();
    }
}