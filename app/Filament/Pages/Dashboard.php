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
use Filament\Support\Facades\FilamentAsset;
use Filament\Events\ServingFilament;
use Filament\Support\Assets\Js;


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
        // FilamentAsset::register([
        //     Js::make('custom-script', asset('js/custom.js')),
        // ]);

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



}
