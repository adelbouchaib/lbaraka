<header>

<nav class="bg-white border-gray-200 dark:bg-gray-900 border">
  <div class="max-w-screen-xl px-3 py-3 sm:mx-auto flex flex-wrap items-center">
    <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="/images/LOGO.png"  class="h-7" alt="Flowbite Logo" />
    </a>
    
    <div class="max-w-md ml-2 md:ml-20 lg:ml-44 flex-1 lg:w-full">   
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>

            <input 
                type="search" 
                id="default-search" 
                wire:model.change="search" 
                class="block w-full p-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="Search Products" 
                required 
            />

            <input 
                type="hidden" 
                wire:model.change="currentUrl" 
                value="{{ request()->fullUrl() }}"
            />
        </div>
    </div>

    
   

    <div class="flex items-center ml-auto">
   

        @if(!auth()->user())
        <button wire:click="goToLogin" type="button" class="font-arabic ml-2 text-white bg-primary hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            الدخول</button>
        @else
        <a href="{{ auth()->user()->role === 'seller' ? '/seller/filachat' : '/filachat' }}">
        <button class="relative px-1 mx-1 ml-4 mr-2 sm:mr-4 border-2 border-transparent text-gray-800 rounded-full hover:text-gray-400 focus:outline-none focus:text-gray-500 transition duration-150 ease-in-out" aria-label="Messages">
            <x-heroicon-o-chat-bubble-left-ellipsis class="h-7 w-7" />

            @if($unreadCount > 0)
                <span class="absolute top-0 right-0 -mt-2 -mr-1">
                    <div class="inline-flex items-center justify-center w-5 h-5 text-xs font-semibold text-white bg-red-500 border-2 border-white rounded-full">
                        {{$unreadCount}}
                    </div>
                </span>
            @endif
        </button>
        </a>

        <button wire:click="goToLogin" 
            type="button" 
            class="mb-2 flex items-center justify-center">
            

            <!-- User Avatar Icon -->
            <svg class="w-7 h-7 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 14a5 5 0 100-10 5 5 0 000 10zm0 2c-4.418 0-8 1.79-8 4v1h16v-1c0-2.21-3.582-4-8-4z"/>
            </svg>

        </button>
        @endif
    </div>


    
  </div>
</nav>

</header>