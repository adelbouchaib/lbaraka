<?php

namespace App\Livewire\Partials;

use Livewire\Component;

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
    
    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
