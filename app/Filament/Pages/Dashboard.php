<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

use App\Filament\Widgets\Performance;
use App\Filament\Widgets\Stats;
use App\Filament\Widgets\StatsDelivered;
use Illuminate\Support\Facades\Auth;

use App\Models\FilachatConversation;
use App\Models\Inquiry;
use App\Models\FilachatMessage;


class Dashboard extends Page
{

    protected ?string $heading = '';

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    public static function getNavigationLabel(): string
    {
        return __('Dashboard'); // Change Dashboard name
    }



    public $inquiries;

    public function mount()
    {   

        $userId = Auth::id();
        $this->inquiries = Inquiry::whereHas('conversation', function ($query) use ($userId) {
            $query->where('senderable_id', $userId)
                  ->orWhere('receiverable_id', $userId);
        })
        ->with(['conversation', 'message', 'product']) // Eager load conversation and message
        ->latest('updated_at')
        ->get();

    }

    public function redirectToConversation($conversationId)
    {
        return redirect("/seller/chat/{$conversationId}");
    }


}
