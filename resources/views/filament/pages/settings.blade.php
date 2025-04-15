<x-filament-panels::page>
<form wire:submit.prevent="save">

<div class="flex justify-center items-center flex-col gap-4">
    <div class="bg-white rounded-xl max-w-lg overflow-hidden w-full rounded-xl border p-6">

   

            <!-- Profile Edit Form -->
                <!-- Full Name Field -->
                <div class="mb-6">
                    <label for="name" class="block text-gray-700 text-sm font-semibold mb-2"> {{ __('Full Name') }}</label>
                    <input type="text" id="name" wire:model="name"
                        class="block text-sm w-full px-4 py-2 border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder=" {{ __('Enter your full name') }}" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1"></p>
                    @enderror
                </div>

            
                  <!-- Phone Number -->
                <div class="mb-2">
                    <label for="phone" class="block text-sm font-medium text-gray-700"> {{ __('Phone Number') }}</label>
                    <input type="text" wire:model="phone" id="phone" class="mt-1 text-sm block w-full px-3 py-2 border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

               
    </div>

    <div class="bg-white rounded-xl max-w-lg overflow-hidden w-full rounded-xl border p-6 mt-4 sm:mt-0">
    <!-- Email Field -->
    <div class="mb-6">
                        <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">{{ __('Email Address') }}</label>
                        <input type="email" id="email" wire:model="email"
                            class="block w-full px-4 py-2 border border-gray-200 rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="{{ __('Enter your email address') }}" required>
                            @error('email')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                    </div>

        <!-- Password Fields -->
         <div class="flex gap-4">
                    <div class="mb-2">
                        <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">{{ __('New Password') }}</label>
                        <input type="password" id="password" wire:model="password"
                            class="block w-full px-4 py-2 border border-gray-200 rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="{{ __('Enter a new password') }}" autocomplete="new-password">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="password_confirmation" class="block text-gray-700 text-sm font-semibold mb-2">    {{ __('Confirm Password') }}
                        </label>
                        <input type="password" id="password_confirmation" wire:model="password_confirmation"
                            class="block w-full px-4 py-2 border border-gray-200 rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="{{ __('Confirm your new password') }}">
                        @error('password_confirmation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
            </div>
    </div>

     <!-- Save Button -->
<div class="mr-4">
    <button type="submit" class="px-6 py-2 bg-black text-white text-sm rounded-md font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500">
          {{ __('Save Changes') }}
    </button>
</div>
</div>



                </form>


</x-filament-panels::page>
