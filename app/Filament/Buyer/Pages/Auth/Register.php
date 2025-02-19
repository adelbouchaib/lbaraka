<?php

namespace App\Filament\Buyer\Pages\Auth;

use Filament\Pages\Page;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register as BaseRegister;

class Register extends BaseRegister
{

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        $this->getPhoneFormComponent(), 
                    ])
                    ->statePath('data'),
            ),
        ];
    }
 
    protected function getPhoneFormComponent(): Component
    {
        return TextInput::make('phone')
        ->label('Phone Number')
        ->prefix('+213')
        ->required()
        ->tel(); // Example default country code (Algeria)
    
    }
}


