<?php

namespace App\Filament\Buyer\Pages;

use Filament\Pages\Page;

use App\Models\Category;
use App\Models\Product;


class Dashboard extends Page
{
    protected ?string $heading = '';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.buyer.pages.dashboard';

    public $categories;
    public $newProducts;
    public $topProducts = [];
    public $allProducts;

    public $categoriesId = [
        3,4,7
    ];



    public function mount(){
        $this->categories = Category::All();


        foreach ($this->categoriesId as $categoryId) {
            $category = Category::find($categoryId); // Fetch category
            $this->topProducts[$category->name] = Product::where('category_id', $categoryId)
                ->take(3)
                ->get();
        }

        $this->newProducts = Product::latest()->take(4)->get();

        $this->allProducts = Product::latest()->take(20)->get();
    }

}
