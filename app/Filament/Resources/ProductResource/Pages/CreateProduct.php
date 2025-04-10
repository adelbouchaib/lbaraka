<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use App\Models\User;

use Google\Client as GoogleClient;


class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();

        if (!$user->canPostProduct()) {
           
            session()->flash('error', 'You are not allowed to create a product.');
            redirect()->route('filament.seller.pages.dashboard'); // Redirect to an upgrade page

            $this->halt();
    

        }
    
        return $data;

    }
    


  

}
