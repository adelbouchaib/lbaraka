<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\HomePage;
use App\Livewire\ProductDetailPage;
use App\Livewire\ProductsPage;
use App\Livewire\RequestsPage;


Route::get('/', HomePage::class);
Route::get('/products', ProductsPage::class);
Route::get('/products/{product}', ProductDetailPage::class);
Route::get('/requests', RequestsPage::class);


// Route::post('/mark-as-deal', [DealsPage::class]);


// Route::middleware(['auth'])->get('/products', ProductsPage::class)->name('products');
// Route::get('/login', function () {
//     return redirect()->route('filament.auth.login', ['redirect_to' => route('products')]);
// })->name('login');
