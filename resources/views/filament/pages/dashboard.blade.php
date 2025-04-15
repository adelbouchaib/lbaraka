<x-filament-panels::page>

@php
    $user = filament()->auth()->user();
@endphp

<div class="flex items-center gap-x-3">
    <h2 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
        {{ __('filament-panels::widgets/account-widget.welcome', ['app' => config('app.name')]) }}
    </h2>

    <p class="text-sm text-gray-500 dark:text-gray-400">
        {{ filament()->getUserName($user) }}
    </p>

   
</div>

<button
    class="px-4 py-2 flex items-center justify-center gap-2 text-sm bg-primary-600 text-white font-semibold rounded-xl shadow-md transition duration-200"
    id="install-button"
    style="display: none">
    <span>تحصل على إشعارات الرسائل</span>
    <x-heroicon-o-bell class="h-6 w-6 inline-flex" />
</button>




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
                        <div class="flex-1 inline-flex gap-4">
                            <img src="{{ asset('storage/' . $inquiry->product->images[0]) }}" 
                                alt="Profile" 
                                class="object-cover rounded-md"
                                style="width: 80px; height: 80px;"  />

                                <div class="flex-1 flex-col justify-center self-start">
                                    <p class="text-sm font-semibold"> 
                                    استفسار جديد: {{$inquiry->product->name}}
                                    </p>
                                    <p class="text-sm font-light text-gray-600 dark:text-gray-500">
                                            من طرف:  {{$inquiry->buyer->name}}
                                    </p>
                                    <p class="text-sm font-light text-gray-600 dark:text-gray-500">
                                            {{$inquiry->created_at->diffForHumans()}}
                                    </p>
                            </div>
                        </div>
                            

                        <div class="ml-auto">
                            <button wire:click="redirectToConversation({{ $inquiry->conversation->id }})" class="bg-[#fbbc04] flex gap-2 text-white font-semibold px-3 py-2 rounded-lg shadow-md transition duration-300 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                            <span class="hidden sm:block text-sm font-semibold"> الرسائل </span>    
                            <x-heroicon-o-chat-bubble-bottom-center class="h-5 w-5 inline-flex" />
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


@script
<script>




let deferredPrompt;

window.addEventListener('beforeinstallprompt', (event) => {
    event.preventDefault();
    deferredPrompt = event;

    const installButton = document.getElementById('install-button');
    installButton.style.display = 'block';

    installButton.addEventListener('click', () => {
        deferredPrompt.prompt();

        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('User accepted the install prompt');
            } else {
                console.log('User dismissed the install prompt');
            }
            deferredPrompt = null;
        });
    });
});

window.addEventListener('appinstalled', async () => {
    console.log('App installed');

    // Initialize Firebase
    const firebaseConfig = {
        apiKey: "AIzaSyCzz91VFPinYPTQ97Gjoq_lkGObCWib_88",
        authDomain: "lbaraka-1f464.firebaseapp.com",
        projectId: "lbaraka-1f464",
        storageBucket: "lbaraka-1f464.appspot.com",
        messagingSenderId: "825065799200",
        appId: "1:825065799200:web:e790fe16dc95fef0c50645",
        measurementId: "G-JRRLJHPNCX"
    };

    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    // Ask for permission
    const permission = await Notification.requestPermission();
    if (permission === "granted") {
        try {
            const registration = await navigator.serviceWorker.ready;
            const currentToken = await messaging.getToken({
                vapidKey: "BLX4N79hrhWKADdk6elMxsY9nijOccotAwR0mtsv00A8WtAtjK-LRqeR64uCLBNY0RlYCfVy8c5c0n3bnntfsiY",
                serviceWorkerRegistration: registration,
            });

            if (currentToken) {
                console.log("FCM Token:", currentToken);
                sendTokenToServer(currentToken);
            } else {
                console.warn("No registration token available.");
            }
        } catch (err) {
            console.error("Error getting token:", err);
        }
    } else {
        console.warn("Permission not granted");
    }
});

function sendTokenToServer(currentToken) {
    // Livewire or Ajax logic
    @this.call('storeUserToken', currentToken);
}



            

 


</script>



@endscript


