@section('title', 'تسجيل')


<div class="bg-gray-50 w-full h-screen flex items-center justify-center dark:bg-gray-900 rtl">
    <div class="w-full max-w-lg p-6 px-6 sm:px-12 bg-white dark:bg-gray-800 rounded-lg border">

        <img src="{{ asset('images/LOGO.png') }}" class="mx-auto mt-4" alt="logo" width="100">

        <h2 class="text-2xl font-arabic mt-2 font-bold text-center text-gray-900 dark:text-white">
            التسجيل
        </h2>
        <h2 class="text-xl mt-2 font-bold text-center text-gray-900 dark:text-white">
            {{ $step === 1 ? '' : '' }}
        </h2>
    
        <p class="text-xs font-arabic pb-4 text-center text-gray-900 dark:text-white">
            أو 
            <a href="/seller/login" class="hover:underline text-secondary font-semibold">تسجيل الدخول إلى حسابك</a>
        </p>


      

        <form wire:submit.prevent="{{ $step === 1 ? 'nextStep' : 'save' }}" class="mt-4 space-y-6">
            
            @if ($step === 1)

                <div>
                    <label class="mb-2 font-arabic block text-sm  text-gray-700 dark:text-gray-300">الإسم الكامل*</label>
                    <input type="text" wire:model="name" autocomplete="name"
                        class="block w-full px-4 py-2 border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 outline-none rounded-lg dark:bg-gray-700 dark:text-white" autofocus>
                    @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2 font-arabic block text-sm  text-gray-700 dark:text-gray-300">البريد الإلكتروني*</label>
                    <input type="text" wire:model="email" autocomplete="email"
                        class="block w-full px-4 py-2 border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 outline-none rounded-lg dark:bg-gray-700 dark:text-white">
                    @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2 font-arabic block text-sm  text-gray-700 dark:text-gray-300">رقم الهاتف*</label>
                    <input type="tel" wire:model="phone" autocomplete="tel"
                        class="block rtl w-full px-4 py-2 border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 outline-none rounded-lg dark:bg-gray-700 dark:text-white">
                    @error('phone') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2 font-arabic block text-sm  text-gray-700 dark:text-gray-300">كلمة المرور*</label>
                    <div x-data="{ showPassword: false }" class="flex border rounded-lg">
                        <input :type="showPassword ? 'text' : 'password'" wire:model="password"
                            class="w-full px-4 py-2 border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 outline-none rounded-lg dark:bg-gray-700 dark:text-white">
                        <button type="button" @click="showPassword = !showPassword" class="px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 2C4.477 2 0 7.163 0 10c0 2.837 4.477 8 10 8s10-5.163 10-8c0-2.837-4.477-8-10-8zM2 10c0-1.883 4.031-6 8-6s8 4.117 8 6-4.031 6-8 6-8-4.117-8-6zm8-4c-2.21 0-4 1.79-4 4a4 4 0 008 0c0-2.21-1.79-4-4-4zm0 6a2 2 0 110-4 2 2 0 010 4z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2 font-arabic block text-sm  text-gray-700 dark:text-gray-300">تأكيد كلمة المرور*</label>
                    <div x-data="{ showCPassword: false }" class="flex border rounded-lg">
                        <input :type="showCPassword ? 'text' : 'password'" wire:model="password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 outline-none rounded-lg dark:bg-gray-700 dark:text-white">
                        <button type="button" @click="showCPassword = !showCPassword" class="px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 2C4.477 2 0 7.163 0 10c0 2.837 4.477 8 10 8s10-5.163 10-8c0-2.837-4.477-8-10-8zM2 10c0-1.883 4.031-6 8-6s8 4.117 8 6-4.031 6-8 6-8-4.117-8-6zm8-4c-2.21 0-4 1.79-4 4a4 4 0 008 0c0-2.21-1.79-4-4-4zm0 6a2 2 0 110-4 2 2 0 010 4z"/>
                            </svg>
                        </button>  
                    </div>
                    @error('password_confirmation') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>











            @endif

            @if ($step === 2)
    <div class="grid grid-cols-1 gap-4">
        
                            


    <div x-data="{ open: false, selected: '' }" class="relative w-full rtl text-sm font-arabic">
                        <label for="dropdown1" class="block mb-2 text-sm text-gray-700 dark:text-gray-300">ما هو نوع عملك؟</label>
                        <input type="hidden" wire:model.defer="business_type">

                        <button @click="open = !open" class="w-full px-4 py-2 text-left bg-white border border-gray-300 rounded-lg flex justify-between items-center focus:outline-none hover:bg-gray-50">
                            <span x-text="selected ? selected : ''" class="truncate"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute left-0 w-full mt-2 bg-white border border-gray-300 rounded-lg shadow-lg z-10">
                            <ul class="max-h-48 overflow-y-auto rounded-lg">
                                <li @click="selected = 'بائع بالجملة'; $wire.set('business_type', 'بائع بالجملة'); open = false" :class="{'bg-gray-300': selected === 'بائع بالجملة'}" class="flex items-center justify-between px-4 py-2 cursor-pointer hover:bg-gray-200">
                                    <span>بائع بالجملة</span>
                                </li>
                                <li @click="selected = 'مصنع'; $wire.set('business_type', 'مصنع'); open = false" :class="{'bg-gray-300': selected === 'مصنع'}"  class="flex items-center justify-between px-4 py-2 cursor-pointer hover:bg-gray-200">
                                    <span>مصنع</span>
                                </li>
                                <li @click="selected = 'مورد'; $wire.set('business_type', 'مورد'); open = false" :class="{'bg-gray-300': selected === 'مورد'}"  class="flex items-center justify-between px-4 py-2 cursor-pointer hover:bg-gray-200">
                                    <span>مورد</span>
                                </li>
                                <li @click="selected = 'مورد'; $wire.set('business_type', 'مورد'); open = false" :class="{'bg-gray-300': selected === 'مورد'}"  class="flex items-center justify-between px-4 py-2 cursor-pointer hover:bg-gray-200">
                                    <span>وسيط</span>
                                </li>
                            </ul>
                        </div>
                </div>

                    <div x-data="{ open: false, selected: '' }" class="relative w-full rtl text-sm font-arabic">
                        <label for="dropdown1" class="block mb-2 text-sm text-gray-700 dark:text-gray-300">ما هي ولاية عملك؟ </label>
                        <input type="hidden" wire:model.defer="business_wilaya">

                        <button @click="open = !open" class="w-full px-4 py-2 text-left bg-white border border-gray-300 rounded-lg flex justify-between items-center focus:outline-none hover:bg-gray-50">
                            <span x-text="selected ? selected : ''" class="truncate"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute left-0 w-full mt-2 bg-white border border-gray-300 rounded-lg shadow-lg z-10">
                            <ul class="max-h-48 overflow-y-auto rounded-lg">
                            <template x-for="(wilaya, index) in ['1- أدرار', '2- الشلف', '3- الأغواط', '4- أم البواقي', '5- باتنة', '6- بجاية', '7- بسكرة', '8- بشار', '9- البليدة', '10- البويرة', '11- تمنراست', '12- تبسة', '13- تلمسان', '14- تيارت', '15- تيزي وزو', '16- الجزائر', '17- الجلفة', '18- جيجل', '19- سطيف', '20- سعيدة', '21- سكيكدة', '22- سيدي بلعباس', '23- عنابة', '24- قالمة', '25- قسنطينة', '26- المدية', '27- مستغانم', '28- المسيلة', '29- معسكر', '30- ورقلة', '31- وهران', '32- البيض', '33- إليزي', '34- برج بوعريريج', '35- بومرداس', '36- الطارف', '37- تندوف', '38- تيسمسيلت', '39- الوادي', '40- خنشلة', '41- سوق أهراس', '42- تيبازة', '43- ميلة', '44- عين الدفلى', '45- النعامة', '46- عين تموشنت', '47- غرداية', '48- غليزان', '49- تيميمون', '50- برج باجي مختار', '51- أولاد جلال', '52- بني عباس', '53- إن صالح', '54- إن قزام', '55- تقرت', '56- جانت', '57- المغير', '58- المنيعة']" :key="index">
                                    <li @click="selected = wilaya; $wire.set('business_wilaya', wilaya); open = false" :class="{'bg-gray-300': selected === wilaya}" class="flex items-center justify-between px-4 py-2 cursor-pointer hover:bg-gray-200">
                                        <span x-text="wilaya"></span>
                                    </li>
                            </template>
                            </ul>
                        </div>
                    </div>

                    <div x-data="{ open: false, selected: '' }" class="relative w-full rtl text-sm font-arabic">
                        <label for="dropdown1" class="block mb-2 text-sm text-gray-700 dark:text-gray-300">هل توفر التوصيل؟</label>
                        <input type="hidden" wire:model.defer="business_delivery">

                        <button @click="open = !open" class="w-full px-4 py-2 text-left bg-white border border-gray-300 rounded-lg flex justify-between items-center focus:outline-none hover:bg-gray-50">
                            <span x-text="selected ? selected : ''" class="truncate"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute left-0 w-full mt-2 bg-white border border-gray-300 rounded-lg shadow-lg z-10">
                            <ul class="max-h-48 overflow-y-auto rounded-lg">
                                <li @click="selected = 'نعم'; $wire.set('business_delivery', 'نعم'); open = false" :class="{'bg-gray-300': selected === 'نعم'}" class="flex items-center justify-between px-4 py-2 cursor-pointer hover:bg-gray-200">
                                    <span>نعم</span>
                                </li>
                                <li @click="selected = 'لا'; $wire.set('business_delivery', 'لا'); open = false" :class="{'bg-gray-300': selected === 'لا'}"  class="flex items-center justify-between px-4 py-2 cursor-pointer hover:bg-gray-200">
                                    <span>لا</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div x-data="{ open: false, selected: '' }" class="relative w-full rtl text-sm font-arabic">
                        <label for="dropdown1" class="block mb-2 text-sm text-gray-700 dark:text-gray-300">كم عدد المنتجات المتوفرة لديك للبيع بالجملة حاليا؟</label>
                        <input type="hidden" wire:model.defer="business_products">

                        <button @click="open = !open" class="w-full px-4 py-2 text-left bg-white border border-gray-300 rounded-lg  flex justify-between items-center focus:outline-none hover:bg-gray-50">
                            <span x-text="selected ? selected : ''" class="truncate"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute left-0 w-full mt-2 bg-white border border-gray-300 rounded-lg shadow-lg z-10">
                            <ul class="max-h-48 overflow-y-auto rounded-lg">
                                <li @click="selected = '1-10'; $wire.set('business_products', '1-10'); open = false" :class="{'bg-gray-300': selected === '1-10'}" class="flex items-center justify-between px-4 py-2 cursor-pointer hover:bg-gray-200">
                                    <span>1-10</span>
                                </li>
                                <li @click="selected = '10-50'; $wire.set('business_products', '10-50'); open = false" :class="{'bg-gray-300': selected === '1-50'}"  class="flex items-center justify-between px-4 py-2 cursor-pointer hover:bg-gray-200">
                                    <span>10-50</span>
                                </li>
                                <li @click="selected = '50-100'; $wire.set('business_products', '50-100'); open = false" :class="{'bg-gray-300': selected === '50-100'}"  class="flex items-center justify-between px-4 py-2 cursor-pointer hover:bg-gray-200">
                                    <span>50-100</span>
                                </li>
                                <li @click="selected = '100+'; $wire.set('business_products', '100+'); open = false" :class="{'bg-gray-300': selected === '100+'}"  class="flex items-center justify-between px-4 py-2 cursor-pointer hover:bg-gray-200">
                                    <span>100+</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div 
                    x-data="{
    open: false,
    selected: [],
    translations: {
        'Electronics': 'أجهزة إلكترونية',
        'Home appliance': 'أجهزة منزلية',
        'Automobile accessories': 'أكسسوارات السيارات',
        'Bags': 'حقائب',
        'Beauty': 'تجميل',
        'Fashion': 'ملابس',
        'Garden': 'أدوات الحدائق',
        'Health care': 'رعاية صحية',
        'Home decoration': 'ديكور المنزل',
        'Jewelry and watches': 'مجوهرات وساعات',
        'Kids': 'أطفال',
        'Kitchen': 'مطبخ',
        'Packaging': 'تغليف',
        'Pets articles': 'مستلزمات الحيوانات',
        'Shoes': 'أحذية',
        'Sports equipment': 'معدات رياضية',
        'Tools': 'خردوات',
        'Toys': 'ألعاب'
    },
    toggleSelection(value) {
        if (this.selected.includes(value)) {
            this.selected = this.selected.filter(item => item !== value);
        } else {
            this.selected.push(value);
        }
        $wire.set('products_type', this.selected.join(', '));
    }
}"

                    class="relative w-full text-sm rtl font-arabic">
                        <label for="dropdown1" class="block mb-1 text-sm text-gray-700 dark:text-gray-300">ما هو نوع المنتجات؟</label>
                        <input type="hidden" wire:model.defer="products_type">

                        <button @click="open = !open" class="w-full px-4 py-2 text-left bg-white border border-gray-300 rounded-lg flex justify-between items-center focus:outline-none hover:bg-gray-50">
                        <span x-text="selected.length > 0 ? selected.map(item => translations[item] || item).join(', ') : ''" class="truncate"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" class="absolute left-0 w-full mt-2 bg-white border border-gray-300 rounded-lg shadow-lg z-10">
                            <ul class="max-h-48 overflow-y-auto rounded-lg">
                                @foreach($categories as $category)
                                <li @click="toggleSelection('{{$category->name}}')" :class="{'bg-gray-300': selected.includes('{{$category->name}}')}" class="flex items-center justify-between px-4 py-2 cursor-pointer hover:bg-gray-200">
                                    <span>{{ __($category->name) }}</span>
                                <input type="checkbox" :checked="selected.includes('{{$category->name}}')" class="form-checkbox">
                                </li>
                                @endforeach
                               
                            </ul>
                        </div>
                    </div>

                

                
        
    </div>
@endif


            <div class="flex justify-between">
                @if ($step > 1)
                   
                @endif

                <button type="submit"
                    class="px-4 w-full font-semibold font-arabic text-xs py-3 text-white bg-secondary rounded-lg">
                    {{ $step === 1 ? 'أنشئ حسابك كتاجر بالجملة' : 'أكمل التسجيل' }}
                </button>
            </div>
        </form>

    </div>
</div>
