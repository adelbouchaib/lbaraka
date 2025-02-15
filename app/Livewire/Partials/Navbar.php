<?php

namespace App\Livewire\Partials;

use Livewire\Component;

use Illuminate\Support\Facades\Route;

use App\Models\FilachatMessage;

class Navbar extends Component
{
    public function goToHome(){
        if(auth()->user()->role == 'buyer'){
            return redirect('/buyer');
        }else{
            return redirect('/admin');
        }
    }
    public function goToLogin()
    {
        return redirect('/buyer/login'); // Change the URL as needed
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
