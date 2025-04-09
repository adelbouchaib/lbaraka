@section('title', 'Supplaio')


<div >
<section class="bg-[#f6f7f9] rtl border-b">
    <div class="grid grid-cols-1  lg:grid-cols-2 lg:gap-12 items-center bg-[#f6f7f9] lg:h-[600px] mx-4 lg:mx-32">
            <div class="py-16 lg:pb-16 text-center lg:text-start">
                <h1 class="font-arabic rtl mb-8 text-4xl md:text-5xl md:leading-relaxed font-bold tracking-tight leading-relaxed text-gray-900 dark:text-white">
                أفضل تجار الجملة <br>
                في مكان واحد!
                </h1>
                <p class="font-arabic rtl mb-8 text-md leading-relaxed text-gray-500 font-light md:text-xl">
                نوفّر لك منصة لشراء المنتجات  بالجملة مباشرة من الموردين الموثوقين في الجزائر! تواصل مباشر، مع حلول رقمية متطورة لتبسيط عمليات البيع والشراء.        </p>
                <div class="flex flex-col justify-center lg:justify-start lg:mb-16 space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                    <a href="/login" class="font-arabic gap-2 inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-primary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
                        انضم الان
                        <x-heroicon-o-arrow-left class="h-5 w-5" />
                    </a>  
                    <a href="/seller/login" class="font-arabic gap-2 inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-secondary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
                        سجل كتاجر بالجملة
                        <x-heroicon-o-arrow-left class="h-5 w-5" />
                    </a>
                </div>
                
            </div>
            <div class="flex justify-center items-center">
                <img class="w-full h-full object-cover object-center" src="images/5.jpg" alt="">

            </div>
    </div>    
</section>

<section class="bg-blue-50 rtl font-arabic">
    <div class="section-container pb-16 pt-24 bg-blue-50 mx-4 lg:mx-32">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <div class="inline-block bg-blue-100 text-blue-700 text-xs px-4 py-1 rounded-full mb-4">
                لماذا تختار Supplaio؟
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                شراء بالجملة مباشرة من المورد
            </h2>
            <p class="text-gray-600 text-lg">
                نوفر لكم منصة تسهل عملية شراء وبيع المنتجات بالجملة، مع تواصل مباشر مع الموردين الموثوقين وبأسعار تنافسية.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 px-6 md:px-12">
            @php
                $features = [
                    [
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9-4 9 4M3 7v10l9 4 9-4V7M3 7l9 4 9-4" />
                   </svg>',
                                           'title' => 'منتجات متنوعة',
                        'description' => 'تصفح آلاف المنتجات الخاصة بالتجارة الإلكترونية من موردين موثوقين.',
                    ],
                    [
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-gray-700">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
</svg>',
                        'title' => 'أسعار تنافسية',
                        'description' => 'احصل على أفضل العروض بالجملة من موردين مختلفين.',
                    ],
                    [
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-gray-700">
  <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
</svg>',
                        'title' => 'وصول مباشر للموردين',
                        'description' => 'تواصل مباشرة مع موردينا واستفسر على منتجاتهم.',
                    ],
                    [
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-gray-700">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
</svg>',
                        'title' => 'تجربة مميزة للتجار بالجملة',
                        'description' => 'نظام كامل بأدوات إحترافية لإدارة الطلبات، والتواصل مع بائعي التجزئة.',
                    ],
                ];
            @endphp

            @foreach ($features as $feature)
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <div class="bg-gray-100 p-4 rounded-full w-fit mx-auto mb-4">
                        {!! $feature['icon'] !!}
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $feature['title'] }}</h3>
                    <p class="text-gray-600">{{ $feature['description'] }}</p>
                </div>
            @endforeach
        </div>
      
    </div>

    
</section>

<div class="bg-blue-50 flex justify-center items-center">
                <img class="w-full max-w-xl h-full object-cover object-center" src="images/7.png" alt="">
            </div>


<section class="bg-blue-50 rtl font-arabic">
    <div class="section-container py-16 bg-blue-50 mx-4 lg:mx-32">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <div class="inline-block bg-blue-100 text-blue-700 text-xs px-4 py-1 rounded-full mb-4">
                شراء بالجملة بسهولة
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                كيف تستخدم Supplaio؟
            </h2>
            <p class="text-gray-600 text-lg">
            نوفر لك تجربة شراء وبيع بالجملة بسهولة من خلال عملية واضحة خطوة بخطوة.
            </p>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 px-6 md:px-12">
            @php
                $features = [
                    [
                        'icon' => '01', // Replace with actual SVG
                        'title' => 'البحث',
                        'description' => 'ابحث عن المنتج الذي تحتاجه.',
                    ],
                    [
                        'icon' => '02',
                        'title' => 'المقارنة',
                        'description' => 'قارن الأسعار والعروض لاختيار الأنسب لك.',
                    ],
                    [
                        'icon' => '03',
                        'title' => 'الإستفسار',
                        'description' => '.حدد الكمية المطلوبة واستفسر أكثر عن المنتج من المورد',
                    ],
                    [
                        'icon' => '04',
                        'title' => 'الطلب',
                        'description' => 'تواصل مع المورد للطلب واستلم طلباتك بالدفع عند الاستلام.',
                    ],
                ];
            @endphp

            @foreach ($features as $feature)
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <span class="text-blue-600 font-bold text-lg"> {!! $feature['icon'] !!}</span>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4 my-2">{{ $feature['title'] }}</h3>
                    <p class="text-gray-600">{{ $feature['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#f6f7f9] py-8 antialiased dark:bg-gray-900 pb-20 pt-16 md:pt-24">
<div class="flex flex-row justify-between items-center mb-8 mx-4 lg:mx-32">
      <div class="flex-shrink-0">
        <a href="/login" class="font-arabic inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-black border rounded-lg bg-white focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
          عرض كل المنتجات
        </a>
      </div>

      <h1 class="font-arabic text-xl rtl font-semibold tracking-tight leading-none text-gray-900 md:text-2xl lg:text-3xl dark:text-white">
        منتجات متنوعة
      </h1>
    </div>

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

   
  </div>
  <!-- Filter modal -->
</section>

<section class="px-2 bg-white py-8 antialiased dark:bg-gray-900 pt-16 md:pt-24">
    <h1 class="font-arabic mb-8 text-2xl text-center font-semibold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
    إذا كنت تاجر بالجملة إنضم إلينا  
    </h1>
    <p class="font-arabic rtl text-md font-normal leading-relaxed text-gray-500 lg:text-xl text-center dark:text-gray-400">
    يرجى ملء النموذج أدناه لتزويدنا بتفاصيلك وتسهيل التواصل معك لاحقًا حول حلولنا المصممة خصيصًا لمتطلبات عملك.
    </p>

    <div class="flex rtl flex-col mb-8 mt-8 lg:mb-16 space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-3">
            <a href="/seller/login" class="font-arabic gap-2 inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-secondary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
                سجل الآن
                <x-heroicon-o-arrow-left class="h-5 w-5" />
            </a> 
            <a href="https://wa.me/+213559913711" class="font-arabic inline-flex gap-2 justify-center items-center py-3 px-5 text-base font-medium text-center border text-gray-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
                تواصل معنا
                <x-heroicon-o-arrow-left class="h-5 w-5" />
            </a>  
    </div>

  


</section>

</div>


