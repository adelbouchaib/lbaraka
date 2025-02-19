<div class="bg-white w-full h-screen">
<div class="flex items-center justify-center bg-white dark:bg-gray-900 w-full pt-28">
    <div class="w-full max-w-md p-6 bg-white dark:bg-gray-800">
        <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Complete Your Profile</h2>

        <form wire:submit.prevent="save" class="mt-4 space-y-4">
            <input type="hidden" wire:model="provider">
            <input type="hidden" wire:model="provider_id">
            <input type="hidden" wire:model="email">

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                <input type="text" id="name" wire:model="name"
                    class="block w-full px-4 py-2 mt-1 text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required>
                @error('name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-600 dark:text-gray-300">
                        +213
                    </span>
                    <input type="tel" id="phone" wire:model="phone"
                        class="block w-full pl-14 pr-4 py-2 text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="0XXXXXXXXX"
                        required>
                </div>
                @error('phone') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>


            <button type="submit"
                class="w-full px-4 py-2 text-white transition bg-primary rounded-lg hover:bg-primary-700 focus:ring-2 focus:ring-primary-500 dark:bg-primary-500 dark:hover:bg-primary-600">
                Complete Registration
            </button>
        </form>
    </div>
</div>
</div>
