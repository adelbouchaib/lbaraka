<?php

namespace App\Livewire\Partials;

use Livewire\Component;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


use App\Models\FilachatMessage;

class Navbar extends Component
{
    
    public function goToLogin()
    {
        $user = Auth::user(); // Get the authenticated user

        if (!$user) {
            return redirect('/login'); // Redirect to login if not logged in
        }
    
        // Check user role and redirect
        if ($user->role == "seller") {
            return redirect()->route('filament.seller.pages.dashboard');
        } elseif ($user->role == "buyer") {
            return redirect()->route('filament.buyer.pages.dashboard');
        }
    
        // Default fallback redirect
        return redirect('/');
    }

    public function goToProducts()
    {
        return redirect('/products');  // Redirect to the /products page
    }

    public $search = '';
    #[Url(as: 'search')] // Bind search term to URL

    public function updatedSearch()
    {
        // Emit the search event with the input value
        $this->dispatch('searchUpdated', $this->search);
        return redirect()->route('products', ['searchTerm' => $this->search]);

    }


    public $unreadCount;

    public function render()
    {
        $unreadCount = FilachatMessage::where(function($query) {
            $query->where('receiverable_id', auth()->id())  // Check receiver
                ->whereNull('last_read_at');
        })
        ->distinct('filachat_conversation_id') // Ensure uniqueness
        ->count(); 

        $this->unreadCount = $unreadCount;
        return view('livewire.partials.navbar', [
            'unreadCount' => $unreadCount
        ]);
    }
}
