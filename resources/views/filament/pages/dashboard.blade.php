<x-filament-panels::page>

@php
    $user = filament()->auth()->user();
@endphp

<div class="flex items-center gap-x-3">
    <h2 class="text-base font-semibold leading-6 text-gray-950">
        {{ __('filament-panels::widgets/account-widget.welcome', ['app' => config('app.name')]) }}
    </h2>

    <p class="text-sm text-gray-500">
        {{ filament()->getUserName($user) }}
    </p>

   

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
    <h1 class="ml-3 font-semibold"> {{__('Message center')}} </h1>
    @php $notHasReply = 0; @endphp
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
        @php $notHasReply ++; @endphp
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
                            <p class="text-sm font-light text-gray-600">
                            </p>
                    </div>

                        <div class="hidden md:flex w-full justify-between items-center gap-4">

                                <div class="flex flex-col ml-auto">
                                    <p class="text-sm font-semibold truncate"> 
                                        Sender
                                    </p>
                                    <p class="text-sm font-light text-gray-600">
                                        {{$inquiry->buyer->name}}
                                    </p>
                                </div>
                                <div class="flex flex-col ml-4">
                                    <p class="text-sm font-semibold truncate"> 
                                        New Inquiry
                                    </p>
                                    <p class="text-sm font-light text-gray-600">
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

    @if($notHasReply == 0)
    <div class="p-2 rounded-xl mt-4 py-4 border flex items-center justify-center">
        <p class="text-sm font-semibold text-gray-600">{{__('No new inquiries')}}</p>
    </div>
    @endif
</div>


    

</x-filament-panels::page>
