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

    // #[Url(as: 'search')]
    public $selectedCategories = [];
    // #[Url]
    public $searchTerm;
    public $selectedMinPrice;
    public $selectedMaxPrice;

    public $sortOption = 'Newest';

   public function loginContact(){
                return redirect('/login');
   }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategories()
    {
        $this->resetPage();
    }

    // protected $listeners = ['searchUpdated']; // Listen for search input updates
    // public function searchUpdated($search)
    // {
    //     $this->searchTerm = $search;
    //     $this->resetPage();
    // }

    public function mount()
    {
        // Check if the user is not authenticated
        // if (auth()->guest()) {
        //     return redirect('/login');
        // }

        // Read query parameters from the URL (after the redirect)
        if (request()->has('searchTerm')) {
            $this->searchTerm = request('searchTerm');
        }
        if (request()->has('categories')) {
            $this->selectedCategories = request('categories');
        }
        if (request()->has('minPrice')) {
            $this->selectedMinPrice = request('minPrice');
        }
        if (request()->has('maxPrice')) {
            $this->selectedMaxPrice = request('maxPrice');
        }
    }

    public $perPage = 20; // Number of products per page
    public function loadMore()
    {
        $this->perPage += 20; // Increase the number of products displayed
    }

    public function showResults(){
        return redirect()->route('products', [
            'searchTerm' => $this->searchTerm,
            'categories' => $this->selectedCategories,
            'minPrice' => $this->selectedMinPrice,
            'maxPrice' => $this->selectedMaxPrice,

        ]);
    }

    public function setSortOption($option)
    {
        $this->sortOption = $option;
    }
    
    public function render()
    {

        $query = Product::where('is_active', '1');

        switch ($this->sortOption) {
            case 'Oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'Increasing price':
                $query->orderBy('price', 'asc');
                break;
            case 'Decreasing price':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        if(!empty($this->selectedCategories)){
            $query->whereIn('category_id', $this->selectedCategories);
        }
        if (!empty($this->searchTerm)) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%');
        }
        if (!empty($this->selectedMinPrice)) {
            $query->where('price', '>=', $this->selectedMinPrice);
        }
        if (!empty($this->selectedMaxPrice)) {
            $query->where('price', '<=', $this->selectedMaxPrice);
        }

        return view('livewire.products-page', [
            'products' => $query->paginate($this->perPage),
            'categories' => Category::all()
        ]);

    }
}
