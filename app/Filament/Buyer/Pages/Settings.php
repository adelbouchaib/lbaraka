<?php

namespace App\Filament\Buyer\Pages;

use Filament\Pages\Page;

use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.buyer.pages.settings';

    protected static bool $shouldRegisterNavigation = false;


    public $name;
    public $email;
    public $phone;  // New phone number field
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone; // Fetch phone number from the database
    }



public function save()
{
    $user = Auth::user();

    // If email is changing, require password
    if ($this->email && $this->email !== $user->email) {
        $this->validate([
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'Please provide a new password to update your email.',
        ]);
    }else{
        $this->validate([
            'password' => 'nullable|min:8|confirmed',
        ]);
    }

    // Validate other fields (after checking email change)
    $this->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('users', 'email')->ignore($user->id), // More readable syntax
        ],
        'phone' => 'nullable|string|max:15|min:9|unique:users,phone',

    ], [
        'email.unique' => 'This email has already been used.',
    ]);

    // Update password if provided
    if ($this->password) {
        $user->password = Hash::make($this->password);
        $this->reset('password', 'password_confirmation'); // Clears input
    }

    // Update user details
    $user->name = $this->name;
    $user->email = $this->email;
    $user->phone = $this->phone;

    $user->save();

    // Send a Filament notification using Livewire event
    Notification::make()
        ->title('Changes saved successfully!')
        ->success()
        ->send();
}

}
