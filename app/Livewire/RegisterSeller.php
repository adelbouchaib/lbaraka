<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SellerLead;
use Illuminate\Support\Facades\Hash;

class RegisterSeller extends Component
{
    public $step = 1;
    public $email, $name, $phone, $password, $password_confirmation;
    public $business_type, $business_wilaya, $business_delivery, $business_products, $products_type;
    public $userId;


    protected $rules = [
        1 => [
            'email' => 'required|email|unique:seller_leads,email',
            'name' => 'required|string|min:3',
            'phone' => 'required|string|min:9|max:15|unique:seller_leads',
            'password' => 'required|min:6|confirmed',
        ],
        2 => [
            'business_type' => 'required|string|min:1',
            'business_wilaya' => 'required|string|min:1',
            'business_delivery' => 'required|string|min:1',
            'business_products' => 'required|string|min:1',
            'products_type' => 'required|string|min:1',
        ],
    ];

    
    public function nextStep()
    {
        $this->validate($this->rules[$this->step]);

            // Create a new record
            $user = SellerLead::create([
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'password' => Hash::make($this->password),

            ]);

            $this->userId = $user->id;



        $this->step++;
    }

    public function save()
    {
        $this->validate($this->rules[2]);

        // Ensure the user is updated instead of duplicated
            SellerLead::where('id', $this->userId)->update([
                'business_type' => $this->business_type,
                'business_wilaya' => $this->business_wilaya,
                'business_delivery' => $this->business_delivery,
                'business_products' => $this->business_products,
                'products_type' => $this->products_type,
            ]);

        return redirect()->route('thankyou.seller')->with('success', 'Profile completed successfully!');
    }

    public function render()
    {
        $categories = \App\Models\Category::all();
        return view('livewire.register-seller', [
            'categories' => $categories, 
        ])->layout('components.layouts.guest');
    }
}
