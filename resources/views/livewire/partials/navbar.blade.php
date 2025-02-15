<header>

<nav class="bg-white border-gray-200 dark:bg-gray-900 border">
  <div class="max-w-screen-xl flex flex-wrap items-center mx-auto">
    <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
    </a>
    
    <div class="max-w-md ml-2 lg:ml-8 flex-1 lg:w-full">   
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
                class="block w-full p-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
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

    <a href="/buyer/filachat">
    <button class="py-4 px-1 relative border-2 border-transparent text-gray-800 rounded-full hover:text-gray-400 focus:outline-none focus:text-gray-500 transition duration-150 ease-in-out" aria-label="Messages">
        <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8-1.78 0-3.438-.464-4.829-1.268L3 20l1.336-4.829C3.464 13.438 3 11.78 3 10c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>

        @if($unreadCount > 0)
            <span class="absolute inset-0 object-right-top -mr-6 mt-1">
                <div class="inline-flex items-center px-1.5 border-2 border-white rounded-full text-xs font-semibold leading-4 bg-red-500 text-white">
                    {{$unreadCount}}
                </div>
            </span>
        @endif
    </button>
    </a>


    <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse ml-auto">
        @if(!Auth::check())
        <button wire:click="goToLogin" type="button" class="text-arab text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">الدخول</button>
        @else
        <!-- <button wire:click="goToProducts" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Show Products</button> -->
        <button wire:click="goToHome" 
        type="button" 
        class="ml-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium 
            rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 
            sm:block hidden">

            View Dashboard
        </button>

        <!-- Mobile Avatar -->
        <button wire:click="goToHome" 
            type="button" 
            class="sm:hidden w-8 h-8 rounded-full border border-gray-500 border-2 flex items-center justify-center">
            

            <!-- User Avatar Icon -->
            <svg class="w-6 h-6 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 14a5 5 0 100-10 5 5 0 000 10zm0 2c-4.418 0-8 1.79-8 4v1h16v-1c0-2.21-3.582-4-8-4z"/>
            </svg>


        </button>
        @endif
    </div>


    
  </div>
</nav>

</header>