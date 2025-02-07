<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Product;  // Import the Product model

class ProductsPage extends Component
{
    public function mount()
    {
        // Check if the user is not authenticated
        if (auth()->guest()) {
            // Redirect to the buyer login page if the user is not authenticated
            return redirect('/buyer/login');
        }
    }

    public function render()
    {
        $productQuery = Product::query()->where('is_active', 1);
        return view('livewire.products-page', [
            'products' => $productQuery->paginate(9),
        ]);
    }
}
