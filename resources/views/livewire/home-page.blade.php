<div >
<section>
    <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-12">
        <h1 class="font-arabic mb-8 text-4xl font-semibold tracking-tight leading-relaxed text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
            مباشرة من المورد، منتجات بالجملة، وبدون عمولة
        </h1>
        <p class="font-arabic mb-8 text-md leading-relaxed text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">
        نوفّر لك منصة لشراء المنتجات بالجملة من الموردين الموثوقين في الجزائر، بدون أي عمولات إضافية! سهولة في الطلب، تواصل مباشر، وحلول رقمية متطورة لتبسيط عمليات البيع والشراء.        </p>
        <div class="flex flex-col mb-8 lg:mb-16 space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
            <a href="#" class="font-arabic inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-primary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
                انضم الان
                <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </a>  
        </div>
       
    </div>
</section>

<section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12">
        <h1 class="mb-4 font-arabic text-2xl text-center font-semibold tracking-tight leading-none text-gray-900 md:text-3xl lg:text-4xl dark:text-white">
        منتجات من مجالات مختلفة   
         </h1>
<div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
<div x-data="{ isMobile: window.innerWidth < 640 }" 
     x-init="window.addEventListener('resize', () => isMobile = window.innerWidth < 640)">
    
    <div class="flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory scrollbar-hide"
         :class="isMobile ? 'flex-nowrap' : 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4'">
        
        @foreach($products as $product)
            <a href="{{ url('/products/' . $product->slug) }}" 
               class="flex-none w-3/4 sm:w-1/2 md:w-full snap-center rounded-lg border border-gray-200 bg-white p-3 sm:p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                
               <div class="w-full aspect-square overflow-hidden rounded mb-2 relative">
                <div class="absolute top-0 left-0">
                    <span class="bg-yellow-500 text-white px-2 py-1 rounded-tr-md rounded-bl-md text-sm font-bold">
                        {{$product->category->name}}
                    </span>
                </div>
                <img class="w-full h-full object-cover object-center" 
                    src="{{ asset('storage/' . $product->images[0]) }}" 
                    alt="" />
            </div>

                <div>
                    <p class="font-arabic rtl line-clamp-2 text-sm sm:text-base leading-tight text-gray-900 dark:text-white">
                        {{ $product->name }}
                    </p>
                    <div class="mt-2 rtl flex items-center justify-between gap-4">
                        <p class="text-lg sm:text-xl font-bold leading-tight text-gray-900 dark:text-white mt-2">
                            {{ $product->price }} دج
                        </p>
                    </div>
                    
                </div>
            </a>
        @endforeach
    </div>
</div>

    <div class="flex flex-col mb-8 mt-8 lg:mb-16 space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
            <a href="#" class="font-arabic inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-primary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
                شاهد المزيد
                <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </a>  
    </div>
  </div>
  <!-- Filter modal -->
</section>

<section class="px-2 bg-white py-8 antialiased dark:bg-gray-900 md:py-12">
    <h1 class="font-arabic mb-8 text-2xl text-center font-semibold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
    إذا كنت تاجر بالجملة إنضم إلينا  
    </h1>
    <p class="font-arabic text-md font-normal leading-relaxed text-gray-500 lg:text-xl text-center dark:text-gray-400">
    يرجى ملء النموذج أدناه لتزويدنا بتفاصيلك وتسهيل التواصل معك لاحقًا حول حلولنا المصممة خصيصًا لمتطلبات عملك.
    </p>

    <div class="flex flex-col mb-8 mt-8 lg:mb-16 space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
            <a href="#" class="font-arabic inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-secondary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
                سجل الآن
                <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </a>  
    </div>


</section>

</div>
