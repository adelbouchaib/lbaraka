<x-filament-panels::page>

<section class="rounded-xl bg-center bg-no-repeat bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/conference.jpg')] bg-gray-700 bg-blend-multiply">
    <div class="px-4 mx-auto max-w-screen-xl text-center py-24">
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">We find for you the product you want</h1>
        <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">Post customized product request to get quotes from multiple matching suppliers.</p>
        <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0 mb-8">
            <div class="max-w-xl w-full px-2">
                <form action="{{ route('products') }}" method="GET">
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                    <div class="relative">
                        
                        <!-- Input Field -->
                        <input 
                            type="text" 
                            name="searchTerm" 
                            id="default-search"
                            placeholder="Search products..." 
                            class="block w-full h-10 p-2.5 py-6 pl-4 pr-12 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        >
                        
                        <!-- Search Button -->
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-500 text-white px-3 py-1.5 rounded-md hover:bg-blue-600">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<div class="flex gap-4 flex-row">
    <h1 class="text-3xl font-bold leading-6 text-gray-950 dark:text-white">
    New arrivals 
    </h1>
    <h1 class="text-xl ml-auto leading-6 text-gray-950 dark:text-white">
    View more ->
    </h1>
</div>

<div x-data="{ isMobile: window.innerWidth < 640 }" 
     x-init="window.addEventListener('resize', () => isMobile = window.innerWidth < 640)">
    
    <div class="flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory scrollbar-hide"
         :class="isMobile ? 'flex-nowrap' : 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4'">
        
        @foreach($newProducts as $product)
            <a href="{{ url('/products/' . $product->slug) }}" 
               class="flex-none w-3/4 sm:w-1/2 md:w-full snap-center rounded-lg border border-gray-200 bg-white p-3 sm:p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                
                <div class="w-full aspect-square overflow-hidden rounded mb-2">
                    <img class="w-full h-full object-cover object-center" 
                         src="{{ asset('storage/' . $product->images[0]) }}" alt="" />
                </div>

                <div>
                    <p class="line-clamp-2 text-sm sm:text-base leading-tight text-gray-900 dark:text-white">
                        {{ $product->name }}
                    </p>
                    <div class="mt-2 flex items-center justify-between gap-4">
                        <p class="text-lg sm:text-xl font-bold leading-tight text-gray-900 dark:text-white mt-2">
                            {{ $product->price }} DA
                        </p>
                    </div>
                    
                </div>
            </a>
        @endforeach
    </div>
</div>


<div class="flex gap-4 flex-row">
    <h1 class="text-3xl font-bold leading-6 text-gray-950 dark:text-white">
    Categories
    </h1>
    <h1 class="text-xl ml-auto leading-6 text-gray-950 dark:text-white">
    View more ->
    </h1>
</div>

@php $categoryNumber = 1; @endphp

<div class="grid sm:grid-cols-3 gap-6 mb-4">
    @foreach($topProducts as $category => $products)
                            
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-lg font-semibold mb-3 text-center bg-gray-100 p-2 rounded">
                <span class="mr-2 bg-yellow-500 text-white px-2 py-1 rounded-tr-md rounded-bl-md text-sm font-bold">
                #{{ $categoryNumber }}
                @php $categoryNumber++; @endphp
                </span>
                {{ $category }}
            </h2>
            
            <div class="grid gap-4">
                @foreach($products as $index => $product)
                <div class="flex items-center gap-3">
                    <div class="relative w-24 shrink-0">
                        <img src="{{ asset('storage/' . $product->images[0]) }}" 
                            class="w-24 h-24 object-cover rounded-lg" 
                            alt="{{ $product->name }}">
                    </div>
                    <div class="w-full">
                        <p class="text-base text-gray-600">{{ $product->name }}</p>
                    </div>
                </div>

                @endforeach
            </div>
        </div>
    @endforeach
</div>


<div class="flex gap-4 flex-row">
    <h1 class="text-3xl font-bold leading-6 text-gray-950 dark:text-white">
    Products
    </h1>
    <h1 class="text-xl ml-auto leading-6 text-gray-950 dark:text-white">
    View more ->
    </h1>
</div>

<div class="mb-4 grid gap-4 grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">
        @foreach($allProducts as $product)
          <a href="{{ url('/products/' . $product->slug) }}" class="block rounded-lg border border-gray-200 bg-white p-3 sm:p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
              <div class="w-full aspect-square overflow-hidden rounded mb-2">
                  <img class="w-full h-full object-cover object-center" 
                      src="{{ asset('storage/' . $product->images[0]) }}" 
                      alt="" />
              </div>


              <div>
                  <p class="line-clamp-2 overflow-hidden text-ellipsis text-sm sm:text-base leading-tight text-gray-900 dark:text-white">{{ $product->name }}</p>
                  <div class="mt-2 flex items-center justify-between gap-4">
                      <p class="text-lg sm:text-xl font-bold leading-tight text-gray-900 dark:text-white mt-2">{{ $product->price }} da</p>
                  </div>
                 
              </div>
          </a>
        @endforeach
        <div class="col-span-full text-center mt-6">
        <a href="/all-products"
            class="bg-white px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-100 transition duration-300">
                View All Products
            </a>
        </div>
</div>












 

</x-filament-panels::page>
