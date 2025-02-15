<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;  
use App\Models\FilachatConversation;
use App\Models\FilachatMessage;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite; // Ensure you have a Favorite model



class ProductDetailPage extends Component
{
    public $product; // This will hold the product data
    public $showModal = false;
    public $message = '';
    public $sellerId;


    public function createRow($product_id, $seller_id)
    {
        // $authenticatedBuyerId = auth()->id();
        // $existingConversation = FilachatConversation::where(function($query) use($authenticatedBuyerId, $seller_id){
        //     $query->where('senderable_id', $authenticatedBuyerId)
        //         ->where('receiverable_id', $seller_id);
        // })->orWhere(function($query) use($authenticatedBuyerId, $seller_id){
        //     $query->where('senderable_id', $seller_id)
        //         ->where('receiverable_id', $authenticatedBuyerId);
        // })->first();

        // if($existingConversation){
        //     $product = Product::find($product_id);
        //     $inquiry = Inquiry::create([
        //         'filachat_conversation_id' => $existingConversation->id,
        //         'product_id' => $product->id
        //     ]);

        //     return redirect()->to('buyer/filachat/' . $existingConversation->id);
        // } 
    
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
            $existingConversation = FilachatConversation::create([
                'senderable_id' => auth()->id(),
                'senderable_type' => 'App\Models\User',
                'receiverable_id' => $this->sellerId,
                'receiverable_type' => 'App\Models\User'
            ]);
        }

        // Save the first message if provided
        if (!empty($this->message)) {
            $existingMessage = FilachatMessage::create([
                'filachat_conversation_id' => $existingConversation->id,
                'message' => $this->message,
                'senderable_id' => auth()->id(),
                'senderable_type' => 'App\Models\User',
                'receiverable_id' => $this->sellerId,
                'receiverable_type' => 'App\Models\User'
            ]);

                $product = Product::find($product_id);
                $inquiry = Inquiry::create([
                    'buyer_id' => auth()->id(),
                    'seller_id' => $this->sellerId,
                    'filachat_conversation_id' => $existingConversation->id,
                    'product_id' => $product->id,
                    'message_id' => $existingMessage->id,
                ]);
            
        }

        return redirect()->to('buyer/filachat/' . $existingConversation->id);    
    }

    public function toggleFavorite()
    {
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirect to login if not authenticated
        }

        $favorite = Favorite::where('user_id', Auth::id())->where('product_id', $this->productId)->first();

        if ($favorite) {
            $favorite->delete();
            $this->isFavorited = false;
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'product_id' => $this->productId
            ]);
            $this->isFavorited = true;
        }
    }

    public $isFavorited;
    public $productId;
    public $products;

    // Mount method to accept product slug from the route
    public function mount($product)
    {
         // Check if the user is not authenticated
         if (auth()->guest()) {
            // Redirect to the buyer login page if the user is not authenticated
            return redirect('/buyer/login');
        }
        // Fetch the product based on the slug
        $this->product = Product::where('slug', $product)->firstOrFail();

        // Get products from the same category (excluding the current product)
        $this->products = Product::where('category_id', $this->product->category_id)
        ->where('id', '!=', $this->product->id)
        ->take(8)
        ->get();

                $this->productId = $this->product->id;
                $this->isFavorited = Auth::check() && Favorite::where('user_id', Auth::id())->where('product_id', $this->productId)->exists();

            }


    public function render()
    {
        // Pass the product data to the view
        return view('livewire.product-detail-page', [
            'product' => $this->product,
        ]);
    }
}
