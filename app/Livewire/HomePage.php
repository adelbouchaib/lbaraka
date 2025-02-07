<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;  // Import the Product model

class HomePage extends Component
{

    public function render()
    {

        $productQuery = Product::query()->where('is_active', 1);
        return view('livewire.home-page', [
            'products' => $productQuery->paginate(9),
        ]);
    }
}
