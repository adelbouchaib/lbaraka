<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Product;  // Import the Product model
use App\Models\Category;  // Import the Product model
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class CategoriesPage extends Component
{
    
    use WithPagination;

    #[Url(as: 'search')]
    public $selectedCategories = [];
    #[Url]
    public $searchTerm = '';

    protected $queryString = [
        'searchTerm' => ['except' => ''], // Prevents updating the URL unless manually set
    ];


    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategories()
    {
        $this->resetPage();
    }

    protected $listeners = ['searchUpdated']; // Listen for search input updates
    public function searchUpdated($search)
    {
        $this->searchTerm = $search;
        $this->resetPage();
    }

    public function mount()
    {
        // Check if the user is not authenticated
        if (auth()->guest()) {
            // Redirect to the buyer login page if the user is not authenticated
            return redirect('/buyer/login');
        }
    }

    public $perPage = 20; // Number of products per page
    public function loadMore()
    {
        $this->perPage += 20; // Increase the number of products displayed
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

        return view('livewire.categories-page', [
            'products' => $query->paginate($this->perPage),
            'categories' => Category::all()
        ]);

    }

}
