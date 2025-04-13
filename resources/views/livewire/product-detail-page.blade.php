@section('title', $product->name)

  
  <section class="px-4 xl:px-24 overflow-hidden bg-gray-50 font-poppins dark:bg-gray-800">
    <div class=" py-8 lg:py-16 mx-auto ">
      <div class="flex flex-wrap">
      <div class="w-full mb-8 md:w-1/2 md:mb-0" 
        x-data="{ mainImage: '{{ asset('storage/' . $product->images[0]) }}' }">
        <div class="sticky top-0 overflow-hidden">
            <div class="relative w-full h-[350px] md:h-[500px]"> <!-- Full width, fixed height -->
                <img :src="mainImage" 
                    class="w-full h-full object-contain rounded-lg border bg-gray-100">
                    
            </div>

            <div class="flex flex-wrap">
    @foreach(collect($product->images)->slice(0, 4) as $image)
        <div class="w-1/4 pt-2 xl:pb-6 sm:w-1/4">
            <img src="{{ asset('storage/' . $image) }}"
                 alt=""
                 x-on:click="mainImage='{{ asset('storage/' . $image) }}'"
                 class="object-cover w-full rounded-xl aspect-square cursor-pointer border hover:border-gray-300 hover:border">
        </div>
    @endforeach
</div>



           
          </div>
        </div>
        <div class="w-full px-4 md:w-1/2 ">
          <div class="lg:pl-4">
          <div class="mb-8 rounded-md border bg-white p-6">


          <a href="{{ route('store', $product->seller->store->slug) }}" 
   class="inline-flex font-arabic text-left items-center gap-2 px-4 py-1 text-sm text-gray-800 bg-gray-200 rounded-lg">
    <x-heroicon-o-building-storefront class="h-4 w-4" />
    <span>{{ $product->seller->store->name }}</span>
</a>

  

          <p class="max-w-xl rtl mt-6 xl:mt-2 font-arabic text-2xl md:text-4xl font-semibold">
          {{$product->name}}</p>

          

        <div class="mt-4 xl:mt-6 mb-10">
            <p class="text-2xl  md:text-4xl  rtl mt-2  font-bold leading-tight text-gray-900 dark:text-white mt-2">
                {{ $product->price }} دج</p>
                      
            <p class="font-arabic rtl line-clamp-2 mt-2 overflow-hidden text-ellipsis text-sm  font-light  leading-tight text-gray-800 dark:text-white">
            أقل كمية : {{ $product->moq }} قطع</p>
        </div>

              <!-- <div class="max-w-md py-4 text-gray-700 dark:text-gray-400 prose">
              {!! preg_replace(
                [
                  '/<a\s+[^>]*href="([^"]+)"[^>]*>/',  // Remove href in <a>
                  '/<figcaption\b[^>]*>.*?<\/figcaption>/i' // Remove <figcaption> completely
              ], ['<a>', ''], $product->short_description) !!}    
              </div> -->




              <div class="flex gap-4 rtl">

              @auth
                        @if(auth()->user()->role == 'buyer')
                        <button wire:click="toggleFavorite"
                                class="flex  gap-2  items-center border rounded-lg px-4 xl:px-8 py-2 transition 
                                    {{ $isFavorited ? 'border-red text-white bg-red-400' : 'border-gray-400 bg-white hover:bg-gray-100' }}">
                                
                            {{ $isFavorited ? 'Saved' : 'Save' }}

                            <x-heroicon-o-heart class="h-5 w-5" />


                        </button>
                        @endif
                @endauth

              @auth
              <button wire:click="createRow({{ $product->id }}, {{ $product->seller_id }})" 
                    class="w-full py-3 bg-secondary rounded-lg text-white flex items-center justify-center gap-2 
                    @if(auth()->user()->role !== 'buyer') opacity-50 cursor-not-allowed @endif"
                    @if(auth()->user()->role !== 'buyer') disabled @endif>
                    
                    <span class="font-bold text-lg">Contact supplier</span>
                    
                </button>
              @else
                <a href="{{ route('filament.buyer.auth.login') }}"
                    class="w-full py-3 bg-secondary rounded-full text-white flex items-center justify-center gap-2">
                        <span class="font-bold text-lg">Contact supplier</span>
                    </a>
              @endauth

             
            </div>




            </div>
           
          
             <!-- Livewire Modal -->
              @if($showModal)
                @auth
                      <!-- Show the conversation modal for authenticated users -->
                      <div 
                      
                      class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">

    <div class="bg-white p-6 rounded-lg shadow-xl w-1/3" x-data @click.away="$wire.set('showModal', false)" >
        <!-- Modal Header -->
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h2 class="text-xl font-arabic font-semibold text-gray-900">Contact {{$product->seller->store->name}}</h2>
            <button wire:click="$set('showModal', false)" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Modal Body -->

       

        <p class="text-sm text-gray-600 mb-2">Product:</p>
         <!-- Product Info -->
         <div class="flex items-center space-x-4 mb-4">
          
            <input type="text" value="{{ $product->name }}" 
                   class="w-full p-2 border border-gray-300 bg-gray-100 rounded-lg text-gray-600" 
                   disabled>
        </div>

         <p class="text-sm text-gray-600 mb-2">Quantity:</p>
         <!-- Product Info -->
<div class="flex items-center space-x-4 mb-4">
          
<form class="max-w-xs" x-data="{ 
        quantity: @entangle('quantity'), 
        min: {{$product->moq}}, 
        showQuantity: false 
    }">

    <!-- Checkbox to toggle quantity visibility -->
    <div class="flex items-center space-x-4 mb-3">
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" 
                   @change="showQuantity = !showQuantity; $wire.set('quantity', showQuantity ? min : 0)" 
                   class="sr-only peer">
            <div class="w-11 h-6 bg-gray-300 rounded-full peer-checked:bg-blue-600 peer-checked:after:translate-x-5 after:content-[''] after:absolute after:w-5 after:h-5 after:bg-white after:rounded-full after:shadow-md after:transition-all after:duration-300 after:top-0.5 after:left-0.5">
            </div>
        </label>
    </div>

    <div class="relative flex items-center max-w-[11rem]" x-show="showQuantity" x-cloak>
        
        <!-- Decrement button -->
        <button type="button" 
                @click="quantity = Math.max(quantity - 1, min); $wire.set('quantity', quantity)" 
                class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
            <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
            </svg>
        </button>

        <!-- Quantity input -->
        <input type="text" 
              x-model="quantity" 
              wire:model.defer="quantity" 
              class="bg-gray-50 border-x-0 border h-11 font-medium text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
              required />

        <!-- Increment button -->
        <button type="button" 
                @click="quantity++; $wire.set('quantity', quantity)" 
                class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
            <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
            </svg>
        </button>
    </div>
</form>



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
                    <div class="mt-6 flex justify-end space-x-3">
            
                        <button wire:click="createAndRedirect({{ $product->id }}, {{ $product->seller_id }})"
                                class="w-full px-6 py-2 font-bold text-md text-white bg-secondary rounded-lg hover:bg-secondary-700 focus:outline-none transition-all duration-200">
                            Send inquiry
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

          </div>
        </div>

       
            </div>

                <div class="w-full mb-12 bg-white p-4 ">
                        <!-- Horizontal Line -->
                        
                        <!-- Title -->
                        <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                            Product details
                        </h1>
                        <hr class="border-gray-300 dark:border-gray-600 mb-10">


                        <!-- Description Content -->
                        <div class="prose text-gray-700 dark:text-gray-400 w-full max-w-none">
                            {!! preg_replace(
                                [
                                    '/<a\s+[^>]*href="([^"]+)"[^>]*>/',  // Remove href in <a>
                                    '/<figcaption\b[^>]*>.*?<\/figcaption>/i' // Remove <figcaption> completely
                                ], ['<a>', ''], $product->description) !!}
                         </div>
                 </div>


                 <div class="w-full mb-8">
                        
                        <!-- Title -->
                        <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                        Supplier's popular products
                        </h1>

                        <div class="mb-4 grid gap-4 grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-5">

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

           


            
      </div>

    
    
  </section>
