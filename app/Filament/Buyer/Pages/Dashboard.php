<?php

namespace App\Filament\Buyer\Pages;

use Filament\Pages\Page;

use App\Models\Category;
use App\Models\Product;


class Dashboard extends Page
{
    protected ?string $heading = '';

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.buyer.pages.dashboard';

    public $categories;
    public $newProducts;
    public $topProducts = [];
    public $allProducts;

    public $categoriesId = [
        3,4,7,8,9,10
    ];

    public $visibleCount = 6;

    public function showMore()
    {
        $this->visibleCount += 6;
    }

    public function mount(){
        $this->categories = Category::All();

        $this->newProducts = Product::latest()->take(5)->get();

        $this->allProducts = Product::latest()->take(20)->get();
    }

}
