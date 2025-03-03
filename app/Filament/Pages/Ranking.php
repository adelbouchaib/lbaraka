<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Contracts\Support\Htmlable;


class Ranking extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static string $view = 'filament.pages.ranking';

    protected static bool $shouldRegisterNavigation = false;

    public function getTitle(): string | Htmlable
    {
        return __('Ranking');
    }


    public $deliveredOrdersCount;
    public function mount()
    {

        $userId = Auth::id();
        $this->deliveredOrdersCount = Order::where('approved', 1)
                  ->where('status', 'Delivered')
                  ->count();
    }

}
