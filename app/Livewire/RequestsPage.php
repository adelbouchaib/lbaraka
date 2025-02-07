<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Request;  // Import the Product model


class RequestsPage extends Component
{
    public function mount()
    {
        // Check if the user is not authenticated
        if (auth()->guest() || auth()->user()->role == 'buyer') {
            // Redirect to the buyer login page if the user is not authenticated
            return redirect('/buyer/login');
        }
    }

    public function render()
    {
        $requestQuery = Request::query()->where('status', 'pending');
        return view('livewire.requests-page', [
            'requests' => $requestQuery->paginate(9),
        ]);
    }
}
