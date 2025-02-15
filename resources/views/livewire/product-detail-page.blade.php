  <section class="px-4 xl:px-24 overflow-hidden bg-white font-poppins dark:bg-gray-800">
    <div class=" py-8 lg:py-16 mx-auto ">
      <div class="flex flex-wrap">
      <div class="w-full mb-8 md:w-1/2 md:mb-0" 
        x-data="{ mainImage: '{{ asset('storage/' . $product->images[0]) }}' }">
        <div class="sticky top-0 overflow-hidden">
            <div class="relative w-full md:h-[500px]"> <!-- Full width, fixed height -->
                <img :src="mainImage" 
                    class="w-full h-full object-contain rounded-lg border bg-gray-100">
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
            </div>

          <div class="flex-wrap flex">
              <div class="w-1/2 p-2 sm:w-1/4">
                  <img src="https://m.media-amazon.com/images/I/71f5Eu5lJSL._SX679_.jpg"
                      alt=""
                      x-on:click="mainImage='https://m.media-amazon.com/images/I/71f5Eu5lJSL._SX679_.jpg'"
                      class="object-cover w-full aspect-square cursor-pointer hover:border hover:border-gray-500">
              </div>

              <div class="w-1/2 p-2 sm:w-1/4">
                  <img src="https://m.media-amazon.com/images/I/61XPhYGQOQL._SX679_.jpg"
                      alt=""
                      x-on:click="mainImage='https://m.media-amazon.com/images/I/61XPhYGQOQL._SX679_.jpg'"
                      class="object-cover w-full aspect-square cursor-pointer hover:border hover:border-gray-500">
              </div>

              <div class="w-1/2 p-2 sm:w-1/4">
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
          <h2 class="max-w-xl mb-6 text-2xl font-bold dark:text-gray-400 md:text-4xl">
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
                  class="w-full py-3 bg-blue-500 rounded-md dark:text-gray-200 text-gray-50 hover:bg-blue-600 dark:bg-blue-500 dark:hover:bg-blue-700 flex items-center justify-center gap-2">
                  
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
                          <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                              <h2 class="text-lg font-semibold">Start a New Conversation?</h2>
                              <p class="text-sm text-gray-600">Write a message to start your chat:</p>

                              <!-- Message Input -->
                              <textarea wire:model="message" 
                                        class="w-full mt-2 p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300" 
                                        rows="3" 
                                        placeholder="Write your message..."></textarea>

                              <div class="mt-4 flex justify-end">
                                  <button wire:click="$set('showModal', false)"
                                          class="mr-2 px-4 py-2 bg-gray-500 text-white rounded">
                                      Cancel
                                  </button>
                                  <button wire:click="createAndRedirect({{ $product->id }}, {{ $product->seller_id }})"
                                  class="px-4 py-2 bg-blue-600 text-white rounded">
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

            <div class="w-full mb-8 md:mb-0">
                <!-- Horizontal Line -->
                <hr class="border-gray-300 dark:border-gray-600 mb-10 mt-20">
                
                <!-- Title -->
                <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6">
                    Products from the same category
                </h1>
      <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">
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
                      </div>


            
      </div>

    
    
  </section>
