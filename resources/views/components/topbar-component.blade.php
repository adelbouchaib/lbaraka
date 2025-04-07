

<a href="/chat" >
<button class="py-4 px-0 relative border-2 border-transparent text-gray-800 rounded-full hover:text-gray-400 focus:outline-none focus:text-gray-500 transition duration-150 ease-in-out sm:hidden" aria-label="Messages">
<x-heroicon-o-chat-bubble-left-ellipsis class="h-7 w-7" />


    @if($unreadCount > 0)
        <span class="absolute inset-0 object-right-top -mr-6 mt-1">
            <div class="inline-flex items-center px-1.5 border-2 border-white rounded-full text-xs font-semibold leading-4 bg-red-500 text-white">
                {{$unreadCount}}
            </div>
        </span>
    @endif
</button>
</a>



