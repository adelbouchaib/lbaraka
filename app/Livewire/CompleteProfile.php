<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\User;
use Illuminate\Support\Facades\Auth;



class CompleteProfile extends Component
{
    public $provider, $provider_id, $email, $name, $phone;

    public function mount()
    {
        $socialUser = session('social_user');

        if (!$socialUser) {
            return redirect()->route('filament.buyer.auth.login');
        }

        $this->provider = $socialUser['provider'];
        $this->provider_id = $socialUser['id'];
        $this->email = $socialUser['email'];
        $this->name = $socialUser['name'];
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required',
        ]);

        // Create the user
        $user = User::create([
            $this->provider . '_id' => $this->provider_id,
            'email_verified_at' => now(),
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'password' => '',
        ]);

        // Log in the user
        Auth::login($user);

        // Clear session
        session()->forget('social_user');

        // Redirect to dashboard
        return redirect()->route('filament.buyer.pages.dashboard')->with('success', 'Profile completed successfully!');
    }

    public function render()
    {
        return view('livewire.complete-profile')->layout('components.layouts.guest');
    }
}