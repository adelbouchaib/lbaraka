<x-filament-panels::page>

@php
    $user = filament()->auth()->user();
    $deliveredOrders = \App\Models\Order::where('seller_id', $user->id)
        ->where('status', 'Delivered')
        ->where('approved', 1)
        ->count();

    // Define badge levels with icons
    if ($deliveredOrders >= 50) {
        $badge = [
            'label' => "Expert ($deliveredOrders Delivered)",
            'color' => 'bg-green-500',
            'icon' => 'heroicon-o-academic-cap' // Graduation cap icon
        ];
    } elseif ($deliveredOrders >= 10) {
        $badge = [
            'label' => "Intermediate ($deliveredOrders Delivered)",
            'color' => 'bg-blue-500',
            'icon' => 'heroicon-o-trending-up' // Growth icon
        ];
    } elseif ($deliveredOrders >= 1) {
        $badge = [
            'label' => "Beginner ($deliveredOrders Delivered)",
            'color' => 'bg-yellow-500',
            'icon' => 'heroicon-o-light-bulb' // Lightbulb icon
        ];
    } else {
        $badge = [
            'label' => 'New Seller',
            'color' => 'bg-gray-400',
            'icon' => 'heroicon-o-user' // User icon
        ];
    }
@endphp

<div class="flex items-center gap-x-3">
    <h2 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
        {{ __('filament-panels::widgets/account-widget.welcome', ['app' => config('app.name')]) }}
    </h2>

    <p class="text-sm text-gray-500 dark:text-gray-400">
        {{ filament()->getUserName($user) }}
    </p>

    {{-- Badge with Icon --}}
    <a href="{{ url('/admin/ranking') }}">
    <span class="ml-2 flex items-center gap-1 px-3 py-1 text-xs font-semibold text-white rounded-full {{ $badge['color'] }}">
    <x-dynamic-component :component="$badge['icon']" class="w-4 h-4" />
    <span class="text-base font-bold">{{ explode('(', $badge['label'])[0] }}</span>  
    <span class="text-xs opacity-80">({{ $deliveredOrders }} Delivered)</span>
    <x-heroicon-o-arrow-right class="w-3 h-3" />
    </span>
    
    </a>

</div>


    <div class="">
        @livewire(\App\Filament\Widgets\Performance::class)
    </div>

    <div class="flex gap-4">
        <div class="flex-1">
        @livewire(\App\Filament\Widgets\Stats::class)
        </div>
        <div class="flex-1">
        @livewire(\App\Filament\Widgets\StatsDelivered::class)
        </div>
    </div>


    
<div class="bg-white border border-gray-300 rounded-lg p-4">            
    <h1 class="ml-3 font-semibold"> Message center </h1>
    @foreach ($this->inquiries as $inquiry)
    @php
        // Get the last message in the conversation
        $lastMessage = \App\Models\FilachatMessage::where('filachat_conversation_id', $inquiry->conversation->id)
            ->where('senderable_id', auth()->id())
            ->latest('created_at')
            ->first();        
        
        // Check if this message is the last one
        $hasReply = $inquiry->message->id < optional($lastMessage)->id;
    @endphp

        @if(!$hasReply)
        <div class="p-2 rounded-xl mt-2 border">
        <a wire:key="{{ $inquiry->id }}" wire:navigate>
            <div class="flex items-center justify-start w-full gap-4">
                <img src="{{ asset('storage/' . $inquiry->product->images[0]) }}" 
                    alt="Profile" 
                    class="object-cover rounded-md"
                    style="width: 80px; height: 80px;"  />
            <div class="flex flex-col self-start">
                    <p class="text-sm font-semibold truncate"> 
                        Inquiry from {{$inquiry->product->name}}
                    </p>
                    <p class="text-sm font-light text-gray-600 dark:text-gray-500">
                    </p>
            </div>

                <div class="hidden md:flex w-full justify-between items-center gap-4">

                        <div class="flex flex-col ml-auto">
                            <p class="text-sm font-semibold truncate"> 
                                Sender
                            </p>
                            <p class="text-sm font-light text-gray-600 dark:text-gray-500">
                                {{$inquiry->buyer->name}}
                            </p>
                        </div>
                        <div class="flex flex-col ml-4">
                            <p class="text-sm font-semibold truncate"> 
                                New Inquiry
                            </p>
                            <p class="text-sm font-light text-gray-600 dark:text-gray-500">
                                Pending: {{$inquiry->created_at->diffForHumans()}}
                            </p>
                        </div>

                        <button wire:click="redirectToConversation({{ $inquiry->conversation->id }})" class="bg-blue-500 text-white font-semibold px-4 py-2 rounded-lg shadow-md transition duration-300 hover:bg-blue-600 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                            Reply now
                        </button>
                    </div>

            </div>
        </a>
        </div>
        @endif
    @endforeach
</div>


    

</x-filament-panels::page>
