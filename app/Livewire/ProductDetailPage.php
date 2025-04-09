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
    public $moq;
    public $isFavorited;
    public $productId;
    public $products;
    public $quantity;


    public function createRow($product_id, $seller_id)
    {
        $this->sellerId = $seller_id;
        $this->showModal = true;
    }

    public function createAndRedirect($product_id, $seller_id)
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
        $product = Product::find($product_id);

        $messageQuantity = ''; // Initialize variable

        if (!empty($this->quantity)) {
            $messageQuantity = 'Quantity: ' . $this->quantity . "<br>";
        }

        // Save the first message if provided
        $customizedQuantity = ' Product: ' . $product->name . "<br>" . $messageQuantity . ' Message: ' . $this->message;
        $existingMessage = FilachatMessage::create([
            'filachat_conversation_id' => $existingConversation->id,
            'message' => $customizedQuantity,
            'senderable_id' => auth()->id(),
            'senderable_type' => 'App\Models\User',
            'receiverable_id' => $this->sellerId,
            'receiverable_type' => 'App\Models\User'
        ]);

            $inquiry = Inquiry::create([
                'buyer_id' => auth()->id(),
                'seller_id' => $this->sellerId,
                'filachat_conversation_id' => $existingConversation->id,
                'product_id' => $product->id,
                'message_id' => $existingMessage->id,
                'quantity' => $this->quantity
            ]);
        
        

        return redirect()->to('chat/' . $existingConversation->id);    
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



    public function mount($product)
    {
        // if (auth()->guest()) {
        //     return redirect('/login');
        // }

        $this->product = Product::where('slug', $product)->firstOrFail();

        $this->products = Product::where('category_id', $this->product->category_id)
        ->where('id', '!=', $this->product->id)
        ->take(8)
        ->get();

        $this->productId = $this->product->id;
        $this->isFavorited = Auth::check() && Favorite::where('user_id', Auth::id())->where('product_id', $this->productId)->exists();

    }


    public function render()
    {
        return view('livewire.product-detail-page', [
            'product' => $this->product,
            'quantity' => $this->product->moq
        ]);
    }
}
