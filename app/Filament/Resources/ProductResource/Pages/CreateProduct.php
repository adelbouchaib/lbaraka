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
    

    protected function afterCreate(): void
    {
       $notice = $this->record;
    
       $credentialsFilePath = storage_path('app/json/file.json');
    //    dd($credentialsFilePath);
  
       $client = new GoogleClient();

       $client->setAuthConfig($credentialsFilePath);

       $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
       $client->refreshTokenWithAssertion();
       $token = $client->getAccessToken();

       $access_token = $token['access_token'];

       // Set up the HTTP headers
       $headers = [
           "Authorization: Bearer $access_token",
           'Content-Type: application/json'
       ];

       $data = [
           "message" => [
               "topic" => "shyam",
               "notification" => [
                   "title" => "New Notification",
                   "body" => "Notification Content",

               ],
               "apns" => [
                   "payload" => [
                       "aps" => [
                           "sound" => "default"
                       ]
                   ]
               ]
           ]
       ];
       $payload = json_encode($data);

       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/lbaraka-1f464/messages:send');
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
       curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
       $response = curl_exec($ch);
       $err = curl_error($ch);
       curl_close($ch);

    //    if($err){
    //     dd($err);
    //    } else {
    //     dd($response);
    //    }
    }

  

}
