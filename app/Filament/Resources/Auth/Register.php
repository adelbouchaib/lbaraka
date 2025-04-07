<?php

namespace App\Filament\Resources\Auth;

use App\Filament\Resources\AuthResource;
use Filament\Pages\Auth\Register as AuthRegister;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Component;


class Register extends AuthRegister
{



    public function form(Form $form): Form
    {
        return $form ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPhoneFormComponent(), 
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data');
        
    }

    protected function getPhoneFormComponent(): Component
    {
        return TextInput::make('phone')
        ->label('Phone Number')
        ->unique('seller_leads', 'phone')
        ->prefix('+213')
        ->required()
        ->tel(); // Example default country code (Algeria)
    
    }

    protected function afterRegister(Authenticatable $user): RedirectResponse
    {
        return redirect()->route('dashboard'); // Change to your custom page
    }



}
