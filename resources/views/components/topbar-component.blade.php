@if (!request()->is('buyer/dashboard')) 
<div class="max-w-md w-full px-2">
    <form action="{{ route('products') }}" method="GET">
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <!-- Input Field -->
            <input 
                type="text" 
                name="searchTerm" 
                id="default-search"
                placeholder="Search products..." 
                class="block w-full h-10 p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" 
            >
        </div>
    </form>
</div>
@endif

<a href="/buyer/filachat" >
<button class="py-4 px-1 relative border-2 border-transparent text-gray-800 rounded-full hover:text-gray-400 focus:outline-none focus:text-gray-500 transition duration-150 ease-in-out sm:hidden" aria-label="Messages">
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



