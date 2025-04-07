<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Store;
use App\Models\Product;
use Livewire\WithPagination;
use App\Models\FilachatConversation;
use App\Models\FilachatMessage;

class StorePage extends Component
{
    use WithPagination; // ✅ Use the trait


    public $store;
    public $selectedCategories = [];
    public $searchTerm;
    public $selectedMinPrice;
    public $selectedMaxPrice;
    public $showModal;
    public $message = '';
    public $sellerId;


    public function mount($store)
    {
        $this->store = Store::where('slug', $store)
        ->where('is_active', true)
        ->firstOrFail();

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

public function updatingSearchTerm()
{
    $this->resetPage();
}

public function updatingSelectedCategories()
{
    $this->resetPage();
}


public function showResults(){
    $this->resetPage(); // Reset pagination for new results

}

public function redirectToLogin()
{
    return redirect('/login');
}

public function createAndRedirect($seller_id)
{

    // Validate input data
    $validatedData = $this->validate([
        'message' => 'required|string|min:5|max:500', // Adjust limits as needed
    ], [
        'message.required' => 'The message field is required.',
        'message.min' => 'The message must be at least 5 characters.',
        'message.max' => 'The message cannot exceed 500 characters.',
    ]);

    $authenticatedBuyerId = auth()->id();
    $existingConversation = FilachatConversation::where(function($query) use($authenticatedBuyerId, $seller_id){
        $query->where('senderable_id', $authenticatedBuyerId)
            ->where('receiverable_id', $seller_id);
    })->orWhere(function($query) use($authenticatedBuyerId, $seller_id){
        $query->where('senderable_id', $seller_id)
            ->where('receiverable_id', $authenticatedBuyerId);
    })->first();

    if(!$existingConversation){
        $existingConversation = FilachatConversation::create([
            'senderable_id' => auth()->id(),
            'senderable_type' => 'App\Models\User',
            'receiverable_id' => $this->sellerId,
            'receiverable_type' => 'App\Models\User'
        ]);
    }


    // Save the first message if provided
    $existingMessage = FilachatMessage::create([
        'filachat_conversation_id' => $existingConversation->id,
        'message' => $this->message,
        'senderable_id' => auth()->id(),
        'senderable_type' => 'App\Models\User',
        'receiverable_id' => $this->sellerId,
        'receiverable_type' => 'App\Models\User'
    ]);
    

    return redirect()->to('/chat/' . $existingConversation->id);    
}



public function createRow($seller_id)
{
    $this->sellerId = $seller_id;
    $this->showModal = true;
}


    public function render()
    {
        // dd($this->store->featured_products);

        $featuredProductIds = $this->store->featured_products; // Decode the JSON array

        if($featuredProductIds !== null) {
            $featuredProducts = \App\Models\Product::whereIn('id', $featuredProductIds)->get();
        }

        $query = $this->store->user->products()->where('is_active', true);

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

        return view('livewire.store-page', [
            'store' => $this->store,
            // 'storeProducts' => $this->store->user->products()->get(),
            'storeProducts' => $query->get(),
            'featuredProducts' => $featuredProducts ?? [],
            'categories' => \App\Models\Category::all(),
        ]);
    }
}
