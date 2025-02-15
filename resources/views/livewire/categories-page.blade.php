<section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12">
<div x-data="{
    selected: @entangle('selectedCategories'),
    startIndex: 0,
    perPage: 4, // Desktop: Show 4 items per page
    isDesktop: window.innerWidth >= 769,
    mobileViewWidth: window.innerWidth < 769 ? 'calc(100% / 2.5)' : '25%', // Show 2.5 items on mobile
    updateLivewire(id) {
        this.selected = [id]; 
        $wire.set('selectedCategories', this.selected);
    },
    next() {
        if (this.isDesktop && this.startIndex + this.perPage < {{ count($categories) }}) {
            this.startIndex += this.perPage;
        }
    },
    prev() {
        if (this.isDesktop && this.startIndex > 0) {
            this.startIndex -= this.perPage;
        }
    },
    updateScreenSize() {
        this.isDesktop = window.innerWidth >= 769;
        this.mobileViewWidth = this.isDesktop ? '25%' : 'calc(100% / 2.5)'; // Adjust width dynamically
        if (!this.isDesktop) {
            this.startIndex = 0; // Reset for mobile
        }
    }
}" 
x-init="updateScreenSize(); window.addEventListener('resize', updateScreenSize)" 
class="w-full flex px-4 md:px-10 pb-10 items-center justify-between">

    <!-- Previous Button (Hidden on Mobile) -->
    <button @click="prev" 
            :disabled="startIndex === 0" 
            class="hidden sm:hidden md:flex lg:flex w-10 h-10 md:w-16 md:h-12 items-center justify-center bg-gray-200 text-gray-800 rounded-full disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-300 transition">
        ❮
    </button>

    <!-- Scrollable Category Container -->
    <div x-ref="scrollContainer" class="relative w-full overflow-x-auto md:overflow-hidden scroll-smooth space-x-4 p-2 scrollbar-hide">
        <div class="flex transition-transform duration-500 ease-in-out"
             :style="isDesktop ? 'transform: translateX(-' + (startIndex * (100 / perPage)) + '%)' : ''">
             
            @foreach($categories as $cat)
                <div class="flex-shrink-0 p-2" :style="'width: ' + mobileViewWidth">
                    <div @click="updateLivewire({{ $cat->id }})"
                        :class="selected.includes({{ $cat->id }}) ? 'border-blue-500 bg-blue-100' : 'border-gray-300 bg-white'"
                        class="flex flex-col items-center p-4 rounded-3xl border-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                        
                        <input type="checkbox" wire:model="selectedCategories" value="{{ $cat->id }}" class="hidden">
                        
                        <!-- Rounded Image -->
                        <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}" 
                             class="h-20 w-20 object-cover rounded-full border-2 border-gray-300 shadow-sm">
                             
                        <label class="text-sm font-semibold text-gray-800 dark:text-gray-200 cursor-pointer mt-2 text-center">
                            {{ $cat->name }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Next Button (Hidden on Mobile) -->
    <button @click="next" 
            :disabled="startIndex + perPage >= {{ count($categories) }}" 
            class="hidden sm:hidden md:flex lg:flex w-10 h-10 md:w-16 md:h-12 items-center justify-center bg-gray-200 text-gray-800 rounded-full disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-300 transition">
        ❯
    </button>
</div>




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
                        <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white md:ms-2">Categories</a>
                      </div>
                    </li>
                  </ol>
                </nav>
                <h2 class="mt-3 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Products</h2>
          </div>

          

      <div class="flex items-center space-x-4">

      <div class="relative w-full sm:w-64">
    <input type="text" wire:model.change="searchTerm" placeholder="Search products..." 
        class="w-full rounded-md border border-gray-300 px-3 py-2 pr-16 text-sm focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:ring-gray-500">

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