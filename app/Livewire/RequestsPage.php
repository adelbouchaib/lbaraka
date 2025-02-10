<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Request;  // Import the Product model
use App\Models\Category;  // Import the Product model
use Livewire\WithPagination;
use Livewire\Attributes\Url;


class RequestsPage extends Component
{
    use WithPagination;

    #[Url]
    public $selectedCategories = [];
    public $searchTerm = '';


    public function mount()
    {
        // Check if the user is not authenticated
        if (auth()->guest() || auth()->user()->role == 'buyer') {
            // Redirect to the buyer login page if the user is not authenticated
            return redirect('/buyer/login');
        }
    }
    

    public function search()
    {
        // Perform search only when the button is clicked
    }

    public $filterType = 'requests'; // Default selection

public function setFilter($type)
{
    $this->filterType = $type;

    if ($type === 'products') {
        return redirect()->to('/products');
    } elseif ($type === 'requests') {
        return redirect()->to('/requests');
    }
}


    public function render()
    {

        $query = Request::where('status', 'pending');
        if(!empty($this->selectedCategories)){
            $query->whereIn('category_id', $this->selectedCategories);
        }
        if (!empty($this->searchTerm)) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%');
        }

        return view('livewire.requests-page', [
            'requests' => $query->paginate(9),
            'categories' => Category::all()
        ]);
    }
}
