<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;  
use App\Models\FilachatConversation;
use App\Models\FilachatMessage;


class ProductDetailPage extends Component
{
    public $product; // This will hold the product data
    public $showModal = false;
    public $message = '';
    public $sellerId;


    public function createRow($product_id, $seller_id)
    {
        $authenticatedBuyerId = auth()->id();
        $existingConversation = FilachatConversation::where(function($query) use($authenticatedBuyerId, $seller_id){
            $query->where('senderable_id', $authenticatedBuyerId)
                ->where('receiverable_id', $seller_id);
        })->orWhere(function($query) use($authenticatedBuyerId, $seller_id){
            $query->where('senderable_id', $seller_id)
                ->where('receiverable_id', $authenticatedBuyerId);
        })->first();

        if($existingConversation){
            $product = Product::find($product_id);
            $existingConversation->products()->syncWithoutDetaching($product);

            return redirect()->to('buyer/filachat/' . $existingConversation->id);
        } 
    
        $this->sellerId = $seller_id;
        $this->showModal = true;
    }

    public function createAndRedirect($product_id, $seller_id)
    {
        $authenticatedBuyerId = auth()->id();
        $existingConversation = FilachatConversation::where(function($query) use($authenticatedBuyerId, $seller_id){
            $query->where('senderable_id', $authenticatedBuyerId)
                ->where('receiverable_id', $seller_id);
        })->orWhere(function($query) use($authenticatedBuyerId, $seller_id){
            $query->where('senderable_id', $seller_id)
                ->where('receiverable_id', $authenticatedBuyerId);
        })->first();


        if(!$existingConversation){
            $row = FilachatConversation::create([
                'senderable_id' => auth()->id(),
                'senderable_type' => 'App\Models\User',
                'receiverable_id' => $this->sellerId,
                'receiverable_type' => 'App\Models\User'
            ]);

        // Save the first message if provided
        if (!empty($this->message)) {
            FilachatMessage::create([
                'filachat_conversation_id' => $row->id,
                'message' => $this->message,
                'senderable_id' => auth()->id(),
                'senderable_type' => 'App\Models\User',
                'receiverable_id' => $this->sellerId,
                'receiverable_type' => 'App\Models\User'
            ]);
        }

        $product = Product::find($product_id);

        // Attach the product to the conversation
        $row->products()->attach($product);

        return redirect()->to('buyer/filachat/' . $row->id);

        }

        return redirect()->to('buyer/filachat/' . $existingConversation->id);

       
    }

    // Mount method to accept product slug from the route
    public function mount($product)
    {
        // Fetch the product based on the slug
        $this->product = Product::where('slug', $product)->firstOrFail();
    }


    public function render()
    {
        // Pass the product data to the view
        return view('livewire.product-detail-page', [
            'product' => $this->product,
        ]);
    }
}
