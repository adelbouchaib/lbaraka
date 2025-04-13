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
use App\Livewire\Notification;

// use Illuminate\Foundation\Auth\EmailVerificationRequest;



Route::get('/complete-profile', CompleteProfile::class)->name('complete.profile');
 
Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])
    ->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])
    ->name('socialite.callback');

Route::get('/', HomePage::class)->name('home');
Route::get('/products', ProductsPage::class)->name('products');
Route::get('/products/{product}', ProductDetailPage::class);

Route::get('/stores/{store}', StorePage::class)->name('store');


Route::get('/thankyou', ThankyouSeller::class)->name('thankyou.seller');

Route::get('/notification', Notification::class)->name('notification');

// Route::post('/store-user-token', [Notification::class, 'storeUserToken']);


// Route::get('/categories', CategoriesPage::class)->name('categories');


// Route::get('/rank', RankPage::class);

// Route::post('/mark-as-deal', [DealsPage::class]);


// Route::middleware(['auth'])->get('/products', ProductsPage::class)->name('products');
// Route::get('/login', function () {
//     return redirect()->route('filament.auth.login', ['redirect_to' => route('products')]);
// })->name('login');