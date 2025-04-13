@props(['selectedConversation'])
<!-- Right Section (Chat Conversation) -->
<div
    x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('filachat-styles', package: 'jaocero/filachat'))]"
    class="flex flex-col border-r w-full md:w-2/3 overflow-hidden">
    @if ($selectedConversation)
        <!-- Chat Header -->
        <div class="flex items-center h-20 gap-2 p-5 border-b dark:border-gray-800/60 border-gray-200/90">
            <x-filament::avatar
                src="https://ui-avatars.com/api/?name={{ urlencode($selectedConversation->other_person_name) }}"
                alt="Profile" size="lg" />
                
            <div class="flex flex-col">
                <p class="text-base font-bold">{{ $selectedConversation->other_person_name }}</p>
                @php
                    if (auth()->id() === $selectedConversation->receiverable_id) {
                        $isOtherPersonAgent = $selectedConversation->senderable->isAgent();
                    } else {
                        $isOtherPersonAgent = $selectedConversation->receiverable->isAgent();
                    }
                @endphp
                
            </div>

@if(auth()->user()->isSeller())

<div class="w-full flex justify-end" x-data="{ isOpen: false, currentStep: 1 }">
    <!-- Button to Trigger Modal -->
    <x-filament::button wire:click="markAsDeal({{ $selectedConversation->id }})" icon="heroicon-m-paper-airplane" color="primary" size="sm" @click="isOpen = true">
        {{__('New order')}}
    </x-filament::button>

    <!-- Modal Overlay -->
    <div x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">

        <!-- Modal Content -->
        <div class="bg-white rounded-lg shadow-xl xl:w-1/3 p-6">
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b pb-3">
                <h2 class="text-lg font-semibold text-gray-900">
                    <span x-show="currentStep === 1">{{__('Create New Order')}}</span>
                    <span x-show="currentStep === 2">{{__('Order Details')}}</span>
                </h2>
                <button @click="isOpen = false" class="text-gray-500 hover:text-gray-700">✕</button>
            </div>

            <!-- Step 1: Confirmation -->
            <div x-show="currentStep === 1" class="mt-4">
                <!-- Product Selection -->
                <label for="selectedProduct" class="text-sm font-medium text-gray-950 mb-2 block">
                {{__('Products mentioned in your chat history with the supplier')}}
                </label>
                <div class="max-h-[500px] overflow-y-auto space-y-4">
                    @foreach ($selectedInquiries as $selectedInquiry)
                        <label class="border rounded-md p-4 flex items-center cursor-pointer shadow-sm hover:bg-gray-100 transition"
                        x-data="{ isChecked: false }"
                        :class="{ 'bg-primary-100 border-primary-500': isChecked }"
                        x-init="$watch('isChecked', value => { 
                            if (value) { 
                                $wire.set('selectedInquiry', {{ $selectedInquiry->id }});
                                $wire.set('selectedProduct', {{ $selectedInquiry->product->id }});
                            } 
                        })"                        
                        x-effect="isChecked = ($wire.selectedInquiry == {{ $selectedInquiry->id }})">
                            
                            <!-- Visible Custom Radio -->
                            <div class="w-5 h-5 border-2 border-gray-400 rounded-full flex items-center justify-center mr-4">
                                <div class="w-3 h-3 bg-primary-500 rounded-full" x-show="isChecked"></div>
                            </div>

                            <!-- Hidden Radio Input -->
                            <input type="radio" value="{{ $selectedInquiry->id }}" name="inquiry_selection"
                                wire:model="selectedInquiry"
                                wire:click="processStepTwo({{ $selectedInquiry->quantity ?? 0}})"
                                class="hidden"
                                x-on:change="isChecked = true">

                            <!-- Product Image -->
                            @if ($selectedInquiry->product->images[0])  
                                <img src="{{ asset('storage/' . $selectedInquiry->product->images[0]) }}" 
                                    alt="{{ $selectedInquiry->product->name }}" 
                                    class="w-20 h-20 object-cover rounded mr-4">
                            @else
                                <div class="w-20 h-20 bg-gray-300 rounded flex items-center justify-center"> 
                                    <span class="text-gray-500">No Image</span>
                                </div>
                            @endif

                            <!-- Product Info -->
                            <div class="text-sm">
                                <p class="font-medium text-gray-900">{{ $selectedInquiry->product->name }}</p>
                                <p class="text-gray-500">{{ $selectedInquiry->product->price }}</p>
                            </div>
                        </label>
                    @endforeach

                    


                    
                </div>


                <div class="flex gap-2 space-x-2 mt-4 border-t pt-3">
                    <x-filament::button @click="currentStep = 2" color="success">{{__('Next')}}</x-filament::button>
                </div>
            </div>

            <!-- Step 2: Order Details -->
            <div x-show="currentStep === 2" class="mt-4">
              <!-- Buyer Input -->
                <div class="space-y-1 mt-3">
                    <label class="text-sm font-medium text-gray-700">{{__('Buyer')}}</label>
                    <div class="relative">
                        <input type="text" value="{{$selectedConversation->other_person_name}}" 
                            class="w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-lg shadow-sm bg-gray-100 text-gray-700 px-3 py-2"
                            readonly>
                        <input type="hidden" wire:model="buyerId">
                    </div>
                </div>

                <!-- Quantity Input -->
                <div class="space-y-1 mt-3">
                    <label class="text-sm font-medium text-gray-700">{{__('Quantity')}}</label>
                    <div class="relative">
                    <input type="number" wire:model.defer="quantity" x-init="$wire.quantity = '{{ $selectedInquiryQuantity }}'"
                        class="w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-lg shadow-sm px-3 py-2">
                     </div>
                </div>

                @error('selectedProduct')
                                <div class="text-red-500 text-sm">يرجى اختيار المنتج</div>
                @enderror
                @error('quantity')
                                <div class="text-red-500 text-sm">يرجى تحديد الكمية</div>
                @enderror

                <!-- Modal Footer (Back & Submit) -->
                <div class="flex justify-between space-x-2 mt-4 border-t pt-3">
                    <x-filament::button wire:click="submitForm" color="success">{{__('Submit')}}</x-filament::button>
                    <x-filament::button @click="currentStep = 1" color="gray">{{__('Back')}}</x-filament::button>
                </div>
            </div>
        </div>
    </div>
</div>


@else 
<div class="w-full flex justify-end" x-data="{ isOpen: false, currentStep: 1 }">
    <!-- Button to Trigger Modal -->
    <x-filament::button wire:click="reportSupplier({{ $selectedConversation->id }})" icon="heroicon-s-flag" color="gray" size="sm" @click="isOpen = true">
        {{__('Report supplier')}}
    </x-filament::button>

    <!-- Modal Overlay -->
    <div x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">

        <!-- Modal Content -->
        <div class="bg-white rounded-lg shadow-xl xl:w-1/3 p-6">
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b pb-3">
                <h2 class="text-lg font-semibold text-gray-900">
                    <span>{{__('Report Supplier')}}</span>
                </h2>
                <button @click="isOpen = false" class="text-gray-500 hover:text-gray-700">✕</button>
            </div>

           
                <div class="space-y-1 mt-3">
                    <label class="text-sm font-medium text-gray-700">{{__('Supplier')}}</label>
                    <div class="relative">
                        <input type="text" value="{{$selectedConversation->other_person_name}}" 
                            class="w-full border-gray-300 focus:border-gray-300 focus:ring-gray-300 rounded-lg shadow-sm bg-gray-100 text-gray-700 px-3 py-2"
                            readonly>
                        <input type="hidden" wire:model="sellerId">
                    </div>
                </div>
                <div class="space-y-1 mt-3">
                    <label class="text-sm font-medium text-gray-700">{{__('Reason*')}}</label>
                    <div class="relative">
                    <textarea wire:model="reportReason"
                        class="w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-lg shadow-sm text-gray-700 px-3 py-2">
                    </textarea>
                    @error('reportReason') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>

            <div class="space-y-1 mt-3">
                <label for="selectedProduct" class="text-sm font-medium text-gray-700">
                    {{__('Select a product if this report concerns one')}}
                </label>
                <div class="max-h-[500px] overflow-y-auto space-y-4">
                        @foreach ($selectedInquiries as $selectedInquiry)
                            <label class="border rounded-md p-4 flex items-center cursor-pointer shadow-sm hover:bg-gray-100 transition"
                            x-data="{ isChecked: false }"
                            :class="{ 'bg-primary-100 border-primary-500': isChecked }"
                            x-init="$watch('isChecked', value => { 
                                if (value) { 
                                    $wire.set('selectedInquiry', {{ $selectedInquiry->id }});
                                    $wire.set('selectedProduct', {{ $selectedInquiry->product->id }});
                                } 
                            })"                        
                            x-effect="isChecked = ($wire.selectedInquiry == {{ $selectedInquiry->id }})">
                                
                                <!-- Visible Custom Radio -->
                                <div class="w-5 h-5 border-2 border-gray-400 rounded-full flex items-center justify-center mr-4">
                                    <div class="w-3 h-3 bg-primary-500 rounded-full" x-show="isChecked"></div>
                                </div>

                                <!-- Hidden Radio Input -->
                                <input type="radio" value="{{ $selectedInquiry->id }}" name="inquiry_selection"
                                    wire:model="selectedInquiry"
                                    wire:click="processStepTwo({{ $selectedInquiry->quantity ?? 0}})"
                                    class="hidden"
                                    x-on:change="isChecked = true">

                                <!-- Product Image -->
                                @if ($selectedInquiry->product->images[0])  
                                    <img src="{{ asset('storage/' . $selectedInquiry->product->images[0]) }}" 
                                        alt="{{ $selectedInquiry->product->name }}" 
                                        class="w-20 h-20 object-cover rounded mr-4">
                                @else
                                    <div class="w-20 h-20 bg-gray-300 rounded flex items-center justify-center"> 
                                        <span class="text-gray-500">No Image</span>
                                    </div>
                                @endif

                                <!-- Product Info -->
                                <div class="text-sm">
                                    <p class="font-arabic font-medium text-gray-900">{{ $selectedInquiry->product->name }}</p>
                                    <p class="text-gray-500">{{ $selectedInquiry->product->price }} DZD</p>
                                </div>
                            </label>
                        @endforeach
                </div>
            </div>


                <!-- Modal Footer (Back & Submit) -->
                <div class="flex justify-end space-x-2 mt-4 border-t pt-3">
                    <x-filament::button wire:click="submitReport" color="success">{{__('Submit')}}</x-filament::button>
                </div>

           
        </div>
    </div>
</div>
@endif



        </div>

        <!-- Chat Messages -->
        <div x-data="{ markAsRead: false, isTyping:false }" x-init="

            const channel = Echo.channel('filachat');

            channel.listen('.JaOcero\\FilaChat\\Events\\FilaChatMessageReadEvent', e => {
                if (e.conversationId == @js($selectedConversation->id)) {
                    markAsRead = true;
                }
            });
            channel.listen('.JaOcero\\FilaChat\\Events\\FilaChatMessageReceiverIsAwayEvent', e => {
                if (e.conversationId == @js($selectedConversation->id)) {
                    markAsRead = false;
                }
            });

            // listen to typing event and reset the typing status after 3 seconds
            channel.listen('.JaOcero\\FilaChat\\Events\\FilaChatUserTypingEvent', e => {
                if (e.conversationId == @js($selectedConversation->id)) {
                    if(e.receiverId == @js(auth()->id())) {
                        isTyping = true;
                           setTimeout(() => {
                                isTyping = false;
                            }, 3000);
                    }
                }
            });

            " id="chatContainer"
             class="flex flex-col-reverse flex-1 p-5 overflow-y-auto">
            <!-- add the typing indicator to the bottom of the chat box -->
            <div class="flex items-end gap-2 mb-2" x-show="isTyping">
                <x-filament::avatar
                    src="https://ui-avatars.com/api/?name={{ urlencode($selectedConversation->other_person_name) }}"
                    alt="Profile" size="sm" />
                <div class="max-w-md p-2 bg-gray-200 rounded-t-xl rounded-br-xl dark:bg-gray-800" >
                    <p class="text-sm">
                        <svg height="40" width="40" class="loader">
                            <circle class="dot" cx="10" cy="20" r="3" style="fill:grey;" />
                            <circle class="dot" cx="20" cy="20" r="3" style="fill:grey;" />
                            <circle class="dot" cx="30" cy="20" r="3" style="fill:grey;" />
                        </svg>
                    </p>
                </div>
            </div>
            <!-- Message Item -->
            @foreach ($conversationMessages as $index => $message)
                <div wire:key="{{ $message->id }}">
                    @php
                        $nextMessage = $conversationMessages[$index + 1] ?? null;
                        $nextMessageDate = $nextMessage ? \Carbon\Carbon::parse($nextMessage->created_at)->setTimezone(config('filachat.timezone', 'app.timezone'))->format('Y-m-d') : null;
                        $currentMessageDate = \Carbon\Carbon::parse($message->created_at)->setTimezone(config('filachat.timezone', 'app.timezone'))->format('Y-m-d');

                        // Show date badge if the current message is the last one of the day
                        $showDateBadge = $currentMessageDate !== $nextMessageDate;
                    @endphp

                    @if ($showDateBadge)
                        <div class="flex justify-center my-4">
                            <x-filament::badge>
                                {{ \Carbon\Carbon::parse($message->created_at)->setTimezone(config('filachat.timezone', 'app.timezone'))->format('F j, Y') }}
                            </x-filament::badge>
                        </div>
                    @endif
                    @if ($message->senderable_id !== auth()->user()->id)
                        @php
                            $previousMessageDate = isset($conversationMessages[$index - 1]) ? \Carbon\Carbon::parse($conversationMessages[$index - 1]->created_at)->setTimezone(config('filachat.timezone', 'app.timezone'))->format('Y-m-d') : null;

                            $currentMessageDate = \Carbon\Carbon::parse($message->created_at)->setTimezone(config('filachat.timezone', 'app.timezone'))->format('Y-m-d');

                            $previousSenderId = $conversationMessages[$index - 1]->senderable_id ?? null;

                            // Show avatar if the current message is the first in a consecutive sequence or a new day
                            $showAvatar = $message->senderable_id !== auth()->user()->id && ($message->senderable_id !== $previousSenderId || $currentMessageDate !== $previousMessageDate);
                        @endphp
                            <!-- Left Side -->
                        <div class="flex items-end gap-2 mb-2">
                            @if ($showAvatar)
                                <x-filament::avatar
                                    src="https://ui-avatars.com/api/?name={{ urlencode($selectedConversation->other_person_name) }}"
                                    alt="Profile" size="sm" />
                            @else
                                <div class="w-6 h-6"></div> <!-- Placeholder to align the messages properly -->
                            @endif
                            <div class="max-w-md p-2 bg-gray-200 rounded-t-xl rounded-br-xl dark:bg-gray-800">
                                @if ($message->message)
                                    <p class="text-sm">{{ $message->message }}</p>
                                @endif
                                @if ($message->attachments && count($message->attachments) > 0)
                                    @foreach ($message->attachments as $attachment)
                                        @php
                                            $originalFileName = $this->getOriginalFileName($attachment, $message->original_attachment_file_names);
                                        @endphp
                                        <div wire:click="downloadFile('{{ $attachment }}', '{{ $originalFileName }}')" class="flex items-center gap-1 bg-gray-50 dark:bg-gray-700 p-2 my-2 rounded-lg group cursor-pointer">
                                            <div class="p-2 text-white bg-gray-500 dark:bg-gray-600 rounded-full group-hover:bg-gray-700 group-hover:dark:bg-gray-800">
                                                @php
                                                    $icon = 'heroicon-m-x-mark';

                                                    if($this->validateImage($attachment)) {
                                                        $icon = 'heroicon-m-photo';
                                                    }

                                                    if ($this->validateDocument($attachment)) {
                                                        $icon = 'heroicon-m-paper-clip';
                                                    }

                                                    if ($this->validateVideo($attachment)) {
                                                        $icon = 'heroicon-m-video-camera';
                                                    }

                                                    if ($this->validateAudio($attachment)) {
                                                        $icon = 'heroicon-m-speaker-wave';
                                                    }

                                                @endphp
                                                <x-filament::icon icon="{{ $icon }}" class="w-4 h-4" />
                                            </div>
                                            <p class="text-sm text-gray-600 dark:text-white group-hover:underline">
                                                {{ $originalFileName }}
                                            </p>
                                        </div>
                                    @endforeach
                                @endif
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-600 text-start">
                                    @php
                                        $createdAt = \Carbon\Carbon::parse($message->created_at)->setTimezone(config('filachat.timezone', 'app.timezone'));

                                        if ($createdAt->isToday()) {
                                            $date = $createdAt->format('g:i A');
                                        } else {
                                            $date = $createdAt->format('M d, Y g:i A');
                                        }
                                    @endphp
                                    {{ $date }}
                                </p>
                            </div>
                        </div>
                    @else
                        <!-- Right Side -->
                        <div class="flex flex-col items-end gap-2 mb-2">
                            <div class="max-w-md p-2 text-white rounded-t-xl rounded-bl-xl bg-primary-600 dark:bg-primary-500">
                                @if ($message->message)
                                <p class="text-sm">{!! $message->message !!}</p>
                                @endif
                                @if ($message->attachments && count($message->attachments) > 0)
                                    @foreach ($message->attachments as $attachment)
                                        @php
                                            $originalFileName = $this->getOriginalFileName($attachment, $message->original_attachment_file_names);
                                        @endphp
                                        <div wire:click="downloadFile('{{ $attachment }}', '{{ $originalFileName }}')" class="flex items-center gap-1 bg-primary-500 dark:bg-primary-800 p-2 my-2 rounded-lg group cursor-pointer">
                                            <div class="p-2 text-white bg-primary-600 rounded-full group-hover:bg-primary-700 group-hover:dark:bg-primary-900">
                                                @php
                                                    $icon = 'heroicon-m-x-circle';

                                                    if($this->validateImage($attachment)) {
                                                        $icon = 'heroicon-m-photo';
                                                    }

                                                    if ($this->validateDocument($attachment)) {
                                                        $icon = 'heroicon-m-paper-clip';
                                                    }

                                                    if ($this->validateVideo($attachment)) {
                                                        $icon = 'heroicon-m-video-camera';
                                                    }

                                                    if ($this->validateAudio($attachment)) {
                                                        $icon = 'heroicon-m-speaker-wave';
                                                    }

                                                @endphp
                                                <x-filament::icon icon="{{ $icon }}" class="w-4 h-4" />
                                            </div>
                                            <p class="text-sm text-white group-hover:underline">
                                                {{ $originalFileName }}
                                            </p>
                                        </div>
                                    @endforeach
                                @endif
                                <p class="text-xs text-primary-300 dark:text-primary-200 text-end">
                                    @php
                                        $createdAt = \Carbon\Carbon::parse($message->created_at)->setTimezone(config('filachat.timezone', 'app.timezone'));

                                        if ($createdAt->isToday()) {
                                            $date = $createdAt->format('g:i A');
                                        } else {
                                            $date = $createdAt->format('M d, Y g:i A');
                                        }
                                    @endphp
                                    {{ $date }}
                                </p>
                            </div>
                            <template x-if="markAsRead || @js($message->last_read_at) !== null">
                                <p class="text-xs text-gray-600 dark:text-primary-200 text-end">
                                    {{__('Seen at')}}
                                    @php
                                        $lastReadAt = \Carbon\Carbon::parse($message->last_read_at)->setTimezone(config('filachat.timezone', 'app.timezone'));

                                        if ($lastReadAt->isToday()) {
                                            $date = $lastReadAt->format('g:i A');
                                        } else {
                                            $date = $lastReadAt->format('M d, Y g:i A');
                                        }
                                    @endphp
                                    {{ $date }}
                                </p>
                            </template>
                        </div>
                    @endif
                </div>
            @endforeach
            <!-- Repeat Message Item for multiple messages -->
            @if ($this->paginator->hasMorePages())
                <div x-intersect="$wire.loadMoreMessages" class="h-4">
                    <div class="w-full mb-6 text-center text-gray-500">{{__('Loading more messages...')}}</div>
                </div>
            @endif

        </div>



        <!-- Chat Input -->
        <div class="w-full p-4 border-t dark:border-gray-800/60 border-gray-200/90">
            <form wire:submit="sendMessage" class="flex items-end justify-between w-full gap-4">
                <div class="w-full max-h-96 overflow-y-auto">
                    {{ $this->form }}
                </div>
                <div class="p-1">
                    <x-filament::button type="submit" icon="heroicon-m-paper-airplane" class="!gap-0"></x-filament::button>
                </div>
            </form>

            <x-filament-actions::modals />
        </div>
    @else
        <div class="flex flex-col items-center justify-center h-full p-3">
            <div class="p-3 mb-4 bg-gray-100 rounded-full dark:bg-gray-500/20">
                <x-filament::icon icon="heroicon-m-x-mark" class="w-6 h-6 text-gray-500 dark:text-gray-400" />
            </div>
            <p class="text-base text-center text-gray-600 dark:text-gray-400">
                {{__('No selected conversation')}}
            </p>

            <button
  class="px-6 py-2 bg-primary-600 mt-4 text-white font-semibold rounded-xl shadow-md transition duration-200"
  id="notify-btn"

>
اضغط هنا لاستقبال الإشعارات
</button>

<button id="install-button" style="display: none;">Install App</button>


        </div>
    @endif





</div>
@script
<script>
    $wire.on('chat-box-scroll-to-bottom', () => {

        chatContainer = document.getElementById('chatContainer');
        chatContainer.scrollTo({
            top: chatContainer.scrollHeight,
            behavior: 'smooth',
        });

        setTimeout(() => {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }, 400);
    });



    const notifyBtn = document.getElementById('notify-btn');


notifyBtn.addEventListener('click', () => {

    
    console.log("i am working");
  const firebaseConfig = {
    apiKey: "AIzaSyCzz91VFPinYPTQ97Gjoq_lkGObCWib_88",
    authDomain: "lbaraka-1f464.firebaseapp.com",
    projectId: "lbaraka-1f464",
    storageBucket: "lbaraka-1f464.firebasestorage.app",
    messagingSenderId: "825065799200",
    appId: "1:825065799200:web:e790fe16dc95fef0c50645",
    measurementId: "G-JRRLJHPNCX"
  };

  firebase.initializeApp(firebaseConfig);

  const messaging = firebase.messaging();

  let currentToken = null; // Declare a global variable



  // Ask permission and get token
  Notification.requestPermission().then((permission) => {
    if (permission === "granted") {
        new Notification("You're now subscribed to notifications!");
      messaging.getToken({ vapidKey: 'BLX4N79hrhWKADdk6elMxsY9nijOccotAwR0mtsv00A8WtAtjK-LRqeR64uCLBNY0RlYCfVy8c5c0n3bnntfsiY' })
        .then((currentToken) => {
          if (currentToken) {
            console.log("FCM Token:", currentToken);

            // Send this token to your server
            sendTokenToServer(currentToken); // Example: send the token to your server  

          } else {
            console.log("No registration token available.");
          }
        }).catch((err) => {
          console.error("Error getting token:", err);
        });
    } else {
      console.warn("Permission not granted");
    }
  });

  function sendTokenToServer(currentToken) {
        
        // Call the Livewire method and pass the JavaScript variable
        @this.call('storeUserToken', currentToken);
        // window.livewire.emit('storeUserToken', currentToken);

    }


//   // Foreground notification handler
//   messaging.onMessage((payload) => {
//     console.log("Foreground message:", payload);
//     new Notification(payload.notification.title, {
//       body: payload.notification.body,
//     //   icon: '/icon.png'
//     });
//   });


// onMessage(messaging, (payload) => {
//   console.log("Foreground message received:", payload);

//   if (Notification.permission === 'granted') {
//     new Notification(payload.notification.title, {
//       body: payload.notification.body,
//     });
//   }
// });




});



let deferredPrompt; // This will hold the prompt event

// Listen for the 'beforeinstallprompt' event
window.addEventListener('beforeinstallprompt', (event) => {
    // Prevent the default behavior of the prompt
    event.preventDefault();
    // Save the event for later use
    deferredPrompt = event;

    // Show the install button
    const installButton = document.getElementById('install-button');
    installButton.style.display = 'block'; // Make the button visible

    // When the install button is clicked, trigger the install prompt
    installButton.addEventListener('click', () => {
        deferredPrompt.prompt(); // Show the install prompt to the user

        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('User accepted the install prompt');
            } else {
                console.log('User dismissed the install prompt');
            }
            deferredPrompt = null; // Reset the prompt after the user responds
        });
    });
});

window.addEventListener('appinstalled', (event) => {
    console.log('PWA was installed');
    
    // 👉 Add your code here
    // For example:
    alert('Thanks for installing our app!');
    
    // You could also do something like:
    // localStorage.setItem('pwaInstalled', 'true');
    // or redirect to a welcome screen
});



  

 


</script>



@endscript
