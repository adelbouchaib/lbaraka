<?php

namespace App\Filament\Resources\Auth;

use App\Filament\Resources\AuthResource;
use Filament\Pages\Auth\Register as AuthRegister;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;



class Register extends AuthRegister
{

    public function form(Form $form): Form
    {
        return $form ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        Hidden::make('role')  // Use Hidden instead of TextInput
                            ->default('seller'), // Set default value for the role
                    ])
                    ->statePath('data');
        
    }



}
