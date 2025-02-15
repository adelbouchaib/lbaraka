<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use App\Models\FilachatMessage;


class TopbarComponent extends Component
{
    /**
     * Create a new component instance.
     */

    public $unreadCount;
    public function __construct()
    {
         
        $unreadCount = FilachatMessage::where(function($query) {
            $query->where('receiverable_id', auth()->id())  // Check receiver
                ->whereNull('last_read_at');
        })
        ->distinct('filachat_conversation_id') // Ensure uniqueness
        ->count(); 

        $this->unreadCount = $unreadCount;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.topbar-component');
    }
}
