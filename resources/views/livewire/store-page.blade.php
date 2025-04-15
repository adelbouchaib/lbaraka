@section('title', $store->name)

<div>
<div class="flex items-center justify-center">
    <div class="bg-blue-100 rounded-xl inline-flex items-center justify-center py-8 w-full">
        <div class="text-center">
            <img src="{{ asset('storage/' . $store->logo) }}" alt="Store Logo" class="w-32 h-32 rounded-full mx-auto">

            <div class="pt-6 space-y-2">
                <h1 class="font-arabic text-2xl font-extrabold">{{$store->name}}</h1>
                <p class="text-gray-500 font-arabic text-sm">بائع معتمد - {{$store->location}}</p>
            </div>

            @auth
            <button wire:click="createRow({{ $store->seller_id }})" 
                    class="w-full mt-4 py-3 bg-blue-500 rounded-md dark:text-gray-200 text-gray-50 hover:bg-blue-600 dark:bg-blue-500 dark:hover:bg-blue-700 flex items-center justify-center gap-2 
                    @if(auth()->user()->role !== 'buyer') opacity-50 cursor-not-allowed @endif"
                    @if(auth()->user()->role !== 'buyer') disabled @endif>
                    
                    <span class="font-medium">Contact Supplier</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M4.5 6.75A2.25 2.25 0 0 1 6.75 4.5h10.5a2.25 2.25 0 0 1 2.25 2.25v6.75a2.25 2.25 0 0 1-2.25 2.25H9.622L5.707 18.764a.75.75 0 0 1-1.207-.592V9a2.25 2.25 0 0 1 0-2.25ZM6.75 6a.75.75 0 0 0-.75.75v8.76l2.693-2.54a.75.75 0 0 1 .507-.19h7.8a.75.75 0 0 0 .75-.75V6.75a.75.75 0 0 0-.75-.75H6.75Z" clip-rule="evenodd"/>
                    </svg>
                </button>

                @else

                <button wire:click="redirectToLogin" 
                    class="w-full mt-4 py-3 bg-blue-500 rounded-md dark:text-gray-200 text-gray-50 hover:bg-blue-600 dark:bg-blue-500 dark:hover:bg-blue-700 flex items-center justify-center gap-2">
                    
                    <span class="font-medium">Contact Supplier</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M4.5 6.75A2.25 2.25 0 0 1 6.75 4.5h10.5a2.25 2.25 0 0 1 2.25 2.25v6.75a2.25 2.25 0 0 1-2.25 2.25H9.622L5.707 18.764a.75.75 0 0 1-1.207-.592V9a2.25 2.25 0 0 1 0-2.25ZM6.75 6a.75.75 0 0 0-.75.75v8.76l2.693-2.54a.75.75 0 0 1 .507-.19h7.8a.75.75 0 0 0 .75-.75V6.75a.75.75 0 0 0-.75-.75H6.75Z" clip-rule="evenodd"/>
                    </svg>
                </button>

                @endauth

        </div>
    </div>
</div>


 <!-- Livewire Modal -->
 @if($showModal)
                @auth
                      <!-- Show the conversation modal for authenticated users -->
                      <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-xl w-1/3">
        <!-- Modal Header -->
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Start a New Conversation?</h2>
            <button wire:click="$set('showModal', false)" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Modal Body -->

        <p class="text-sm text-gray-600 mb-2">Supplier:</p>
         <!-- Product Info -->
         <div class="flex items-center space-x-4 mb-4">
          
            <input type="text" value="{{ $store->name }}" 
                   class="w-full p-2 border border-gray-300 bg-gray-100 rounded-lg text-gray-600" 
                   disabled>
        </div>


         

                    <p class="text-sm text-gray-600">Details:</p>
                    <!-- Message Input -->
                    <textarea wire:model="message" 
                              class="w-full mt-2 p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                              rows="4" 
                              placeholder="Write your message..."></textarea>
                              @error('message')
                                  <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative mt-2">
                                      <strong class="font-bold">Error:</strong> {{ $message }}
                                  </div>
                              @enderror

                    <!-- Modal Footer (Cancel & Send Buttons) -->
                    <div class="mt-6 flex justify-end space-x-4">
                        <button wire:click="$set('showModal', false)"
                                class="px-6 py-2 text-sm text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 focus:outline-none transition-all duration-200">
                            Cancel
                        </button>
                        <button wire:click="createAndRedirect({{ $store->seller_id }})"
                                class="px-6 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-primary-700 focus:outline-none transition-all duration-200">
                            Send & Start Chat
                        </button>
                    </div>
                </div>
            </div>

                  @else
                      <!-- Show the login modal for unauthenticated users -->
                      <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
                          <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                              <h2 class="text-lg font-semibold">Login to Start a Conversation</h2>
                              <p class="text-sm text-gray-600">Please login to send a message and start a chat.</p>

                              <div class="mt-4 flex justify-end">
                                  <button wire:click="$set('showModal', false)"
                                          class="mr-2 px-4 py-2 bg-gray-500 text-white rounded">
                                      Cancel
                                  </button>
                                  <button wire:click="redirectToLogin"
                                          class="px-4 py-2 bg-blue-600 text-white rounded">
                                      Login
                                  </button>
                              </div>
                          </div>
                      </div>
                  @endauth
              @endif


    

<div class="lg:px-48 py-8 bg-gray-50">
    <!-- Featured Products -->
    @if(!$featuredProducts->isEmpty())

    <section class="container bg-white py-6 px-10 mx-auto mt-6">
        <h3 class="text-xl font-bold mb-4">Best sellers</h3>
        <div class="mb-4 grid gap-4 grid-cols-2 md:mb-8 lg:grid-cols-4">

          @foreach($featuredProducts as $product)
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

                        <button wire:click="redirectToLogin()" 
                            class="w-full px-4 py-1.5 mt-4 font-semibold border-gray-900 text-gray-900 border rounded-lg hover:text-white hover:border-secondary hover:bg-secondary transition duration-200">
                              
                            <span class="font-medium">Contact supplier</span>
                               
                        </button>
                           
                        @endauth


              </div>
          </a>
          @endforeach
        </div>
    </section>

    @endif


   <!-- Products -->
   <section class="container bg-white py-6 px-10 mx-auto mt-6">
        <div class="mr-0" x-data="{ open: false, search: '' }">

        <div class="flex items-center justify-between w-full">

            <h3 class="text-xl text-left font-bold mb-4">Products</h3>

            <div class="flex items-center gap-x-4">

                <div class="relative w-full sm:w-64">
                    <form wire:submit.prevent="showResults">
                        <input type="text" wire:model.defer="searchTerm" placeholder="Search products..." 
                            class="w-full rounded-md border border-gray-300 px-3 py-2 pr-16 text-sm focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:ring-gray-500">
                    </form>
                </div>


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
            </div>

        </div>

    


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


        <div class="mb-4 grid gap-4 grid-cols-2 md:mb-8 lg:grid-cols-4">

          @foreach($storeProducts as $product)
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

                        <button wire:click="redirectToLogin()" 
                            class="w-full px-4 py-1.5 mt-4 font-semibold border-gray-900 text-gray-900 border rounded-lg hover:text-white hover:border-secondary hover:bg-secondary transition duration-200">
                              
                            <span class="font-medium">Contact supplier</span>
                               
                        </button>
                           
                        @endauth


              </div>
          </a>
          @endforeach
        </div>
    </section>


</div>
</div>