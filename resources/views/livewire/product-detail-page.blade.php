@section('title', $product->name)

  
  <section class="px-4 xl:px-24 overflow-hidden bg-white font-poppins dark:bg-gray-800">
    <div class=" py-8 lg:py-16 mx-auto ">
      <div class="flex flex-wrap">
      <div class="w-full mb-8 md:w-1/2 md:mb-0" 
        x-data="{ mainImage: '{{ asset('storage/' . $product->images[0]) }}' }">
        <div class="sticky top-0 overflow-hidden">
            <div class="relative w-full h-[350px] md:h-[500px]"> <!-- Full width, fixed height -->
                <img :src="mainImage" 
                    class="w-full h-full object-contain rounded-lg border bg-gray-100">
                    @if(auth()->user()->role == 'buyer')
                    <button wire:click="toggleFavorite"
                            class="absolute top-4 right-4 border rounded-full p-2 transition 
                                {{ $isFavorited ? 'border-red-400 bg-red-100' : 'border-gray-400 bg-white hover:bg-gray-100' }}">
                            
                        <!-- Heroicons Heart Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" 
                            class="w-6 h-6 transition" 
                            viewBox="0 0 24 24"
                            fill="{{ $isFavorited ? 'red' : 'white' }}" 
                            stroke="{{ $isFavorited ? 'red' : 'gray' }}" stroke-width="2">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09A5.98 5.98 0 0 1 16.5 3 5.5 5.5 0 0 1 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                        </svg>
                    </button>
                    @endif
            </div>

          <div class="flex-wrap flex">
              <div class="w-1/4 p-2 sm:w-1/4">
                  <img src="https://m.media-amazon.com/images/I/71f5Eu5lJSL._SX679_.jpg"
                      alt=""
                      x-on:click="mainImage='https://m.media-amazon.com/images/I/71f5Eu5lJSL._SX679_.jpg'"
                      class="object-cover w-full aspect-square cursor-pointer hover:border hover:border-gray-500">
              </div>

              <div class="w-1/4 p-2 sm:w-1/4">
                  <img src="https://m.media-amazon.com/images/I/61XPhYGQOQL._SX679_.jpg"
                      alt=""
                      x-on:click="mainImage='https://m.media-amazon.com/images/I/61XPhYGQOQL._SX679_.jpg'"
                      class="object-cover w-full aspect-square cursor-pointer hover:border hover:border-gray-500">
              </div>

              <div class="w-1/4 p-2 sm:w-1/4">
                  <img src="https://m.media-amazon.com/images/I/81v5JNjZ4-L._SX679_.jpg"
                      alt=""
                      x-on:click="mainImage='https://m.media-amazon.com/images/I/81v5JNjZ4-L._SX679_.jpg'"
                      class="object-cover w-full aspect-square cursor-pointer hover:border hover:border-gray-500">
              </div>
          </div>

           
          </div>
        </div>
        <div class="w-full px-4 md:w-1/2 ">
          <div class="lg:pl-4">
          <h2 class="max-w-xl mb-6 text-xl xs:text-2xl font-bold dark:text-gray-400 md:text-4xl">
          {{$product->name}}</h2>
            <div class="mb-8 rounded-md border-2 shadow-md p-6">

            <p class="text-gray-500 text-md mb-1 dark:text-gray-400">
                Min. order: {{ $product->moq }} pieces
            </p>

             
              <p class="inline-block text-4xl font-bold text-gray-700 dark:text-gray-400 ">
                <span>{{$product->price}} DZD</span>
              </p>

              <div class="max-w-md py-4 text-gray-700 dark:text-gray-400 prose">
              {!! preg_replace(
                [
                  '/<a\s+[^>]*href="([^"]+)"[^>]*>/',  // Remove href in <a>
                  '/<figcaption\b[^>]*>.*?<\/figcaption>/i' // Remove <figcaption> completely
              ], ['<a>', ''], $product->short_description) !!}    
              </div>




              <button wire:click="createRow({{ $product->id }}, {{ $product->seller_id }})" 
                    class="w-full py-3 bg-blue-500 rounded-md dark:text-gray-200 text-gray-50 hover:bg-blue-600 dark:bg-blue-500 dark:hover:bg-blue-700 flex items-center justify-center gap-2 
                    @if(auth()->user()->role !== 'buyer') opacity-50 cursor-not-allowed @endif"
                    @if(auth()->user()->role !== 'buyer') disabled @endif>
                    
                    <span class="font-medium">Contact Supplier</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M4.5 6.75A2.25 2.25 0 0 1 6.75 4.5h10.5a2.25 2.25 0 0 1 2.25 2.25v6.75a2.25 2.25 0 0 1-2.25 2.25H9.622L5.707 18.764a.75.75 0 0 1-1.207-.592V9a2.25 2.25 0 0 1 0-2.25ZM6.75 6a.75.75 0 0 0-.75.75v8.76l2.693-2.54a.75.75 0 0 1 .507-.19h7.8a.75.75 0 0 0 .75-.75V6.75a.75.75 0 0 0-.75-.75H6.75Z" clip-rule="evenodd"/>
                    </svg>
                </button>





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
          
            <input type="text" value="{{ $product->seller->name }}" 
                   class="w-full p-2 border border-gray-300 bg-gray-100 rounded-lg text-gray-600" 
                   disabled>
        </div>

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

                    <p class="text-sm text-gray-600">Write a message to start your chat:</p>
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
                        <button wire:click="createAndRedirect({{ $product->id }}, {{ $product->seller_id }})"
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

          </div>
        </div>

       
            </div>

           <div class="w-full mb-8 md:mb-0">
                <!-- Horizontal Line -->
                <hr class="border-gray-300 dark:border-gray-600 mb-10">
                
                <!-- Title -->
                <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6">
                    Product description from the supplier
                </h1>

                <!-- Description Content -->
                <div class="prose text-gray-700 dark:text-gray-400 w-full max-w-none">
                    {!! preg_replace(
                        [
                            '/<a\s+[^>]*href="([^"]+)"[^>]*>/',  // Remove href in <a>
                            '/<figcaption\b[^>]*>.*?<\/figcaption>/i' // Remove <figcaption> completely
                        ], ['<a>', ''], $product->short_description) !!}
                </div>
            </div>

           


            
      </div>

    
    
  </section>
