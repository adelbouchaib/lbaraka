<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Product;  // Import the Product model
use App\Models\Category;  // Import the Product model
use Livewire\WithPagination;
use Livewire\Attributes\Url;


class ProductsPage extends Component
{

    use WithPagination;

    #[Url]
    public $selectedCategories = [];
    public $searchTerm = '';

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

        $query = Product::where('is_active', '1');
        if(!empty($this->selectedCategories)){
            $query->whereIn('category_id', $this->selectedCategories);
        }
        if (!empty($this->searchTerm)) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%');
        }

        return view('livewire.products-page', [
            'products' => $query->paginate(9),
            'categories' => Category::all()
        ]);

    }
}
