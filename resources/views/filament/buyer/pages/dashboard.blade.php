<x-filament-panels::page>


<section class="rounded-xl bg-center bg-primaryx bg-blend-multiply">
<!-- <section class="rounded-xl bg-center bg-no-repeat bg-[url('https://lbaraka.com/images/background.jpg')] bg-gray-700 bg-blend-multiply"> -->
    
    <div class="px-4 mx-auto max-w-screen-xl text-center py-8 sm:py-24">
        <h1 class="mb-8 text-3xl font-extrabold tracking-tight leading-tight text-white md:text-4xl lg:text-5xl">Start searching for products</h1>
        <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
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
                            class="block w-full h-10 p-2.5 py-6 pl-4 pr-12 text-sm text-gray-900 border border-gray-300 rounded-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        >
                        
                        <!-- Search Button -->
                        <button type="submit" class="flex justify-center items-center absolute right-2 top-1/2 -translate-y-1/2 bg-primaryx text-white px-3 py-1.5 rounded-full hover:bg-blue-600">
                            <svg class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<div>
    <div class="flex gap-4 flex-row items-center mb-2">
        <h1 class="text-2xl sm:text-3xl font-bold leading-6 text-gray-950 dark:text-white">
            Categories
        </h1>
    </div>
    <div x-data="{
        startIndex: 0,
        perPage: 4, // Desktop: Show 4 items per page
        isDesktop: window.innerWidth >= 769,
        mobileViewWidth: window.innerWidth < 769 ? 'calc(100% / 2.5)' : '25%', // Show 2.5 items on mobile
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
        class="w-full flex items-center justify-between">

        <!-- Previous Button (Hidden on Mobile) -->
        <button @click="prev" 
                :disabled="startIndex === 0" 
                class="hidden sm:hidden md:flex lg:flex w-10 h-10 md:w-14 md:h-12 items-center justify-center bg-gray-200 text-gray-800 rounded-full disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-300 transition">
            ❮
        </button>

        <!-- Scrollable Category Container -->
        <div x-ref="scrollContainer" class="relative w-full overflow-x-auto md:overflow-hidden scroll-smooth space-x-4 py-2 scrollbar-hide">
            <div class="flex transition-transform duration-500 ease-in-out"
                :style="isDesktop ? 'transform: translateX(-' + (startIndex * (100 / perPage)) + '%)' : ''">
                
                @foreach($categories as $cat)

                    <div class="flex-shrink-0 p-2" :style="'width: ' + mobileViewWidth">
                        <div
                            class="flex flex-col items-center rounded-full cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                            
                            <a href="/products?categories[0]={{$cat->id}}">

                            <img src="{{ asset('images/categories/' . $cat->slug . '.jpg')  }}" alt="{{ $cat->name }}" 



                                class="w-full object-cover rounded-full border-2 border-gray-300 shadow-sm">
                            </a>

                            <!-- <label class="text-sm font-semibold text-gray-800 dark:text-gray-200 cursor-pointer mt-2 text-center">
                                {{ $cat->name }}
                            </label> -->
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Next Button (Hidden on Mobile) -->
        <button @click="next" 
                :disabled="startIndex + perPage >= {{ count($categories) }}" 
                class="hidden sm:hidden md:flex lg:flex w-10 h-10 md:w-14 md:h-12 items-center justify-center bg-gray-200 text-gray-800 rounded-full disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-300 transition">
            ❯
        </button>
    </div>
</div>


<div class="mb-4" x-data="{ isMobile: window.innerWidth < 640 }" 
     x-init="window.addEventListener('resize', () => isMobile = window.innerWidth < 640)">

    <div class="flex gap-4 flex-row items-center mb-4">
    <a href="/products">
        <h1 class="text-2xl sm:text-3xl font-bold leading-6 text-gray-950 dark:text-white">
            Products
        </h1>
    </a>
        <a href="/products" class="ml-auto mr-4">
        <h1 class="text-lg leading-6 text-gray-950 dark:text-white">
            <span class="hidden sm:inline underline">View all</span>
            <span class="text-2xl font-bold">-></span>
        </h1>
        </a>
    </div>
    
    <div class="flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory scrollbar-hide"
         :class="isMobile ? 'flex-nowrap' : 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4'">
        
        @foreach($newProducts as $product)
        <a href="{{ url('/products/' . $product->slug) }}" 
               class="flex-none w-2/3 sm:w-1/2 md:w-full snap-center rounded-lg border border-gray-200 bg-white p-2 sm:p-3  shadow-sm dark:border-gray-700 dark:bg-gray-800">
                
                <div class="w-full aspect-square overflow-hidden rounded mb-2">
                    <img class="w-full h-full object-cover object-center" 
                         src="{{ asset('storage/' . $product->images[0]) }}" alt="" />
                </div>

                <div>
                <p class="font-arabic rtl line-clamp-2 font-light  overflow-hidden  text-base leading-tight text-gray-900 dark:text-white">
                    {{ $product->name }}</p>
                  <p class="text-xl  sm:text-2xl  rtl mt-2  font-bold leading-tight text-gray-900 dark:text-white mt-2">{{ $product->price }} دج</p>
                  
                  <p class="font-arabic rtl line-clamp-2 mt-1 overflow-hidden text-ellipsis text-xs font-light  leading-tight text-gray-800 dark:text-white">
                    أقل كمية : {{ $product->moq }} قطعة</p>
                    
                          
                       

                </div>
            </a>
        @endforeach
    </div>
</div>








 

</x-filament-panels::page>
