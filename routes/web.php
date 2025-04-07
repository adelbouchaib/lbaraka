<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\HomePage;
use App\Livewire\ProductDetailPage;
use App\Livewire\ProductsPage;
use App\Livewire\CategoriesPage;

use App\Http\Controllers\SocialiteController;
use App\Livewire\CompleteProfile;
use App\Livewire\ThankyouSeller;
use App\Livewire\StorePage;

// use Illuminate\Foundation\Auth\EmailVerificationRequest;



Route::get('/complete-profile', CompleteProfile::class)->name('complete.profile');
 
Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])
    ->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])
    ->name('socialite.callback');

Route::get('/', HomePage::class)->name('home');
Route::get('/products', ProductsPage::class)->name('products');
Route::get('/products/{product}', ProductDetailPage::class);

Route::get('/stores/{store}', StorePage::class);


Route::get('/thankyou', ThankyouSeller::class)->name('thankyou.seller');


// Route::get('/categories', CategoriesPage::class)->name('categories');


// Route::get('/rank', RankPage::class);

// Route::post('/mark-as-deal', [DealsPage::class]);


// Route::middleware(['auth'])->get('/products', ProductsPage::class)->name('products');
// Route::get('/login', function () {
//     return redirect()->route('filament.auth.login', ['redirect_to' => route('products')]);
// })->name('login');


use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Http;

Route::get('/testnotification', function () {
    // Get the FCM token for the user you want to send the message to.
    // $fcm = "DEVICE_FCM_TOKEN"; // Get this token from the user record

    // Get the FCM token for the specific user
$user = User::find($userId);  // Assuming $userId is the ID of the user receiving the message
$fcm = $user->fcm_token;  // Get the FCM token from the user's record



    $title = "New Message";
    $description = "You have a new message.";

    // The path to the credentials file (Firebase service account key).
    $credentialsFilePath = public_path('json/file.json'); // In the public folder

    // Create the Google client
    $client = new GoogleClient();
    $client->setAuthConfig($credentialsFilePath);
    $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
    $client->refreshTokenWithAssertion();
    $token = $client->getAccessToken();

    $access_token = $token['access_token'];

    // Prepare the notification data
    $headers = [
        "Authorization: Bearer $access_token",
        'Content-Type: application/json'
    ];

    $data = [
        "message" => [
            "token" => $fcm,
            "notification" => [
                "title" => $title,
                "body" => $description,
            ],
        ]
    ];

    // JSON encode the data
    $payload = json_encode($data);

    // Use CURL to send the request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/lbaraka-1f464/messages:send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        return response()->json([
            'message' => 'Curl Error: ' . $err
        ], 500);
    } else {
        return response()->json([
            'message' => 'Notification has been sent',
            'response' => json_decode($response, true)
        ]);
    }
})->name('testnotification');
