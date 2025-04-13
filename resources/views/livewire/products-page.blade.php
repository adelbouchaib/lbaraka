@section('title', 'Products')


<section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12 min-h-screen">

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

          <div class="relative w-full sm:w-64">
                    <form wire:submit.prevent="showResults">
                        <input type="text" wire:model.defer="searchTerm" placeholder="Search products..." 
                            class="w-full rounded-md border border-gray-300 px-3 py-2 pr-16 text-sm focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:ring-gray-500">
                    </form>
                </div>

<div class="mr-0" x-data="{ open: false, search: '' }">
    <!-- Button to Open Modal -->
    <button @click="open = true" type="button" class="flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 sm:w-auto">
      <svg class="-ms-0.5 me-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M6 12h12m-9 6h6" />
      </svg>
      Filters
      <svg class="-me-0.5 ms-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
      </svg>
    </button>


    <!-- Modal -->
    <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div @click.away="open = false" class="w-full max-w-md rounded-lg bg-white shadow-lg dark:bg-gray-800">
            
            <!-- Modal Header -->
            <div class="border-b px-4 py-3 dark:border-gray-600">
                <h2 class="text-lg font-semibold text-gray-900">Filters</h2>
            </div>

            <!-- Modal Content -->
            <div class="p-4 space-y-6">
                
                <!-- Categories Section -->
                <div>
                    <h3 class="text-md font-medium text-gray-800 border-b pb-2">Categories</h3>

                    <!-- Categories Grid -->
                    <div class="grid grid-cols-2 gap-3 mt-3 max-h-40 overflow-y-auto p-2 border rounded-lg">
                        @foreach($categories as $cat)
                        <div wire:key="{{ $cat->id }}" x-show="$el.textContent.toLowerCase().includes(search.toLowerCase())">
                            <label for="{{ $cat->slug }}" class="flex items-center space-x-2">
                                <input type="checkbox" wire:model="selectedCategories" value="{{ $cat->id }}"
                                    id="{{ $cat->slug }}" class="form-checkbox bg-gray-200 rounded h-4 w-4 text-blue-600">
                                <span class="text-sm text-gray-700">{{ $cat->name }} ({{ $cat->products->count() }})</span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Advanced Filters Section -->
                <div>
                    <h3 class="text-md font-medium text-gray-800 border-b pb-2">Price Range</h3>
                    
                    <div class="flex space-x-3 mt-3">
                        <input type="number" wire:model="selectedMinPrice" placeholder="Min"
                            class="w-1/2 rounded-md border px-3 py-2 text-sm">
                        <input type="number" wire:model="selectedMaxPrice" placeholder="Max"
                            class="w-1/2 rounded-md border px-3 py-2 text-sm">
                    </div>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="border-t px-4 py-3 text-right">
                
                <button wire:click="showResults" @click="open = false"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                    Show Results
                </button>
            </div>
        </div>
    </div>
</div>


      

          <button id="sortDropdownButton1" data-dropdown-toggle="dropdownSort1" type="button" class="flex items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 sm:w-auto">
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
                <a href="#"  wire:click.prevent="setSortOption('Newest')" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"> Newest </a>
              </li>
              <li>
                <a href="#"  wire:click.prevent="setSortOption('Oldest')" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"> Oldest </a>
              </li>
              <li>
                <a href="#"  wire:click.prevent="setSortOption('Increasing price')" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"> Increasing price </a>
              </li>
              <li>
                <a href="#"  wire:click.prevent="setSortOption('Decreasing price')" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"> Decreasing price </a>
              </li>
            </ul>
          </div>
      </div>
      
    </div>


        @if($products->isEmpty())
        <div class="flex items-center justify-center">
        <div class="flex flex-col max-w-xl items-center justify-center text-center bg-gray-100 p-6 rounded-lg shadow-md">
            <x-heroicon-o-magnifying-glass class="w-16 h-16 text-gray-400 mb-4" />

            <h2 class="text-lg font-semibold text-gray-800">Your search did not match any products.</h2>
            <ul class="text-gray-500 text-left text-sm mt-2">
                <li>- Check the spelling</li>
                <li>- Use fewer keywords</li>
                <li>- Try different keywords</li>
            </ul>
            <a href="{{ route('products') }}" class="mt-4 px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition">
                Browse All Products
            </a>
        </div>
    </div>

        @else
        <div class="mb-4 grid gap-4 grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-5">

          @foreach($products as $product)
          <a href="{{ url('/products/' . $product->slug) }}" class="block rounded-lg border border-gray-200 bg-white p-2 sm:p-3 shadow-sm dark:border-gray-700 dark:bg-gray-800">
              <div class="w-full aspect-square overflow-hidden rounded mb-2">
                  <img class="w-full h-full object-cover object-center" 
                      src="{{ asset('storage/' . $product->images[0]) }}" 
                      alt="" />
              </div>


              <div>
                  <p class="font-arabic rtl line-clamp-2 font-light  overflow-hidden  text-base leading-tight text-gray-900 dark:text-white">
                    {{ $product->name }}</p>
                                     

                      <p class="text-xl  sm:text-2xl  rtl mt-2  font-bold leading-tight text-gray-900 dark:text-white mt-2">{{ $product->price }} دج</p>
                      
                      <p class="font-arabic rtl line-clamp-2 mt-1 overflow-hidden text-ellipsis text-xs font-light  leading-tight text-gray-800 dark:text-white">
                        أقل كمية : {{ $product->moq }} قطعة</p>



                        @auth
                          <button wire:click="createRow({{ $product->id }}, {{ $product->seller_id }})" 
                                class="w-full px-4 py-1.5 mt-4 font-semibold border-gray-900 text-gray-900 border rounded-lg hover:text-white hover:border-secondary hover:bg-secondary transition duration-200
                                @if(auth()->user()->role !== 'buyer') cursor-not-allowed @endif"
                                @if(auth()->user()->role !== 'buyer') disabled @endif>
                                
                                <span class="font-medium">Contact supplier</span>
                               
                          </button>
                        @else

                        <button wire:click="loginContact()" 
                            class="w-full px-4 py-1.5 mt-4 font-semibold border-gray-900 text-gray-900 border rounded-lg hover:text-white hover:border-secondary hover:bg-secondary transition duration-200">
                              
                            <span class="font-medium">Contact supplier</span>
                               
                        </button>
                           
                        @endauth


              </div>
          </a>
          @endforeach
        </div>

          </div>
          <div class="mt-6 flex justify-center">
        <div class="inline-flex space-x-2 items-center bg-white p-2 rounded-lg shadow">
            {{ $products->links('vendor.livewire.tailwind') }}
        </div>
        </div>
        @endif
    </div>
  
</section>