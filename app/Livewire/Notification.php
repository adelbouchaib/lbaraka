<?php

namespace App\Livewire;

use Livewire\Component;

use Google_Client as GoogleClient;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Notification extends Component
{

    public $token;

    public function storeUserToken($currentToken)
    {
        // dd($currentToken);
        $this->token = $currentToken;
        $user = Auth::user();
            if ($user && $user->fcm_token !== $this->token) {
                // Store the FCM token in the `fcm_token` column in the users table
                $user->fcm_token = $this->token;
                $user->save();
            }    
    }




    public function afterCreate():void
    {
        // Retrieve the user's FCM token from the database
        $user = Auth::user();
        if($user){
            $fcmToken = $user->fcm_token;
            $credentialsFilePath = public_path('json/file.json');
  
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
                     "token" => $fcmToken, // from JS frontend
     
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
     
        }
        
    }

    public function render()
    {
        return view('livewire.notification');
    }
}
