<section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12">

<div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
    <!-- Heading & Filters -->
    <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
          <div>
                <nav class="flex" aria-label="Breadcrumb">
                  <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                      <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="me-2.5 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                          <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Home
                      </a>
                    </li>
                    <li>
                      <div class="flex items-center">
                        <svg class="h-5 w-5 text-gray-400 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
                        </svg>
                        <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white md:ms-2">Products</a>
                      </div>
                    </li>
                  </ol>
                </nav>
                <h2 class="mt-3 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Products</h2>
          </div>

          

      <div class="flex items-center space-x-4">

          <!-- <div class="relative w-full sm:w-64">
              <input type="text" wire:model.defer="searchTerm" placeholder="Search products..." 
                  class="w-full rounded-md border border-gray-300 px-3 py-2 pr-16 text-sm focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:ring-gray-500">
              
              <button wire:click="search" 
                  class="absolute inset-y-0 right-0 flex items-center px-3 py-1.5 m-1 text-sm font-medium rounded-md border border-gray-300 focus:outline-none focus:ring-2">
                  Search
              </button>
          </div> -->


          <div class="relative w-full sm:w-auto" x-data="{ open: false, search: '' }">
              <!-- Dropdown Button -->
              <button @click="open = !open" type="button" class="flex w-full items-center justify-between rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                  <span>Categories</span>
                  <svg class="h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
              </button>

              <!-- Dropdown List -->
              <div x-show="open" @click.outside="open = false" class="absolute z-10 mt-2 w-full rounded-lg border border-gray-200 bg-white shadow-lg dark:border-gray-600 dark:bg-gray-800">
                  <!-- Search Input -->
                  <div class="p-2">
                      <input type="text" x-model="search" placeholder="Search categories..." class="w-full rounded-md border border-gray-300 px-3 py-1 text-sm focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:ring-gray-500">
                  </div>

                  <!-- Category List -->
                  <ul class="max-h-60 overflow-y-auto p-2">
                      @foreach($categories as $cat)
                          <li wire:key="{{ $cat->id }}" class="mb-1 border" x-show="$el.textContent.toLowerCase().includes(search.toLowerCase())">
                              <label for="{{ $cat->slug }}" class="flex items-center space-x-2 p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                                  <input type="checkbox" wire:model.live="selectedCategories" value="{{ $cat->id }}" id="{{ $cat->slug }}" class="border form-checkbox h-4 w-4 text-blue-600 dark:bg-gray-800">
                                  <span class="text-sm text-gray-700 dark:text-gray-200">{{ $cat->name }}</span>
                              </label>
                          </li>
                      @endforeach
                  </ul>
              </div>
          </div>
      

          <button id="sortDropdownButton1" data-dropdown-toggle="dropdownSort1" type="button" class="flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 sm:w-auto">
            <svg class="-ms-0.5 me-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M7 4l3 3M7 4 4 7m9-3h6l-6 6h6m-6.5 10 3.5-7 3.5 7M14 18h4" />
            </svg>
            Sort
            <svg class="-me-0.5 ms-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
            </svg>
          </button>

          <div id="dropdownSort1" class="z-50 hidden w-40 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700" data-popper-placement="bottom">
            <ul class="p-2 text-left text-sm font-medium text-gray-500 dark:text-gray-400" aria-labelledby="sortDropdownButton">
              <li>
                <a href="#" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"> Newest </a>
              </li>
              <li>
                <a href="#" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"> Increasing price </a>
              </li>
              <li>
                <a href="#" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"> Decreasing price </a>
              </li>
            </ul>
          </div>
      </div>
      
    </div>


    <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">
        @if($products->isEmpty())
        <div class="flex flex-col items-center justify-center text-center bg-gray-100 p-6 rounded-lg shadow-md">
            <svg class="w-16 h-16 text-gray-400 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3-3m0 0l3 3m-3-3v12M4 13h16"/>
            </svg>
            <h2 class="text-lg font-semibold text-gray-800">Your search did not match any products.</h2>
            <p class="text-gray-600 mt-2">You may consider:</p>
            <ul class="text-gray-500 text-sm mt-2">
                <li>✅ Check the spelling</li>
                <li>✅ Use fewer keywords</li>
                <li>✅ Try different keywords</li>
            </ul>
            <a href="{{ route('products') }}" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                Browse All Products
            </a>
        </div>
        @else
          @foreach($products as $product)
          <a href="{{ url('/products/' . $product->slug) }}" class="block rounded-lg border border-gray-200 bg-white p-3 sm:p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
              <div class="w-full aspect-square overflow-hidden rounded mb-2">
                  <img class="w-full h-full object-cover object-center" 
                      src="{{ asset('storage/' . $product->images[0]) }}" 
                      alt="" />
              </div>


              <div>
                  <p class="line-clamp-2 overflow-hidden text-ellipsis text-sm sm:text-base leading-tight text-gray-900 dark:text-white">
                    {{ $product->name }}</p>
                  <div class="mt-2 flex items-center justify-between gap-4">
                      <p class="text-lg sm:text-xl font-bold leading-tight text-gray-900 dark:text-white mt-2">{{ $product->price }} da</p>
                  </div>
                  <p class="line-clamp-2 overflow-hidden text-ellipsis text-sm sm:text-base leading-tight text-gray-900 dark:text-white">
                    Min. order: {{ $product->moq }} pieces</p>
                  <!-- <div class="mt-4 flex items-center justify-between gap-4">
                    <button type="button" 
                        class="w-full items-center rounded-lg bg-white px-5 py-1 sm:py-2.5 text-sm font-medium border border-gray-700 text-gray-700 
                            hover:bg-blue-700 hover:text-white focus:outline-none focus:ring-4 focus:ring-blue-300 
                            dark:bg-white dark:hover:bg-blue-700 dark:text-blue-700 dark:hover:text-white dark:focus:ring-blue-800 
                            @if(!auth()->check() || auth()->user()->role !== 'buyer') opacity-50 cursor-not-allowed @endif"
                        @if(!auth()->check() || auth()->user()->role !== 'buyer') disabled @endif>
                        Chat Now
                    </button>
                  </div> -->
              </div>
          </a>
          @endforeach
          </div>
          <div class="mt-6 flex justify-center">
        <div class="inline-flex space-x-2 items-center bg-white p-2 rounded-lg shadow">
            {{ $products->links('vendor.livewire.tailwind') }}
        </div>
        </div>
        @endif
    </div>
  
</section>