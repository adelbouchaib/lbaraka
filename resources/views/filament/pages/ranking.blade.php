<x-filament-panels::page>
    <div class="pl-10 pr-10">
        <div class="flex justify-center mt-6">
            <div class="grid grid-cols-4 gap-4"">
                @php
                    // Fetch actual delivered orders dynamically (replace with your logic)
                    $deliveredOrders = $deliveredOrdersCount;

                    // Determine current rank based on orders
                    if ($deliveredOrders >= 50) {
                        $currentRank = 'Expert';
                    } elseif ($deliveredOrders >= 10) {
                        $currentRank = 'Intermediate';
                    } elseif ($deliveredOrders >= 1) {
                        $currentRank = 'Beginner';
                    } else {
                        $currentRank = 'New Seller';
                    }

                    $steps = [
                        ['title' => 'New Seller', 'description' => 'Start here with basic privileges.', 'color' => 'bg-green-500'],
                        ['title' => 'Beginner', 'description' => 'Mid-level sellers with better perks and visibility.', 'color' => 'bg-green-500'],
                        ['title' => 'Intermediate', 'description' => 'Experienced sellers with higher benefits.', 'color' => 'bg-green-500'],
                        ['title' => 'Expert', 'description' => 'Top sellers with maximum benefits and priority support.', 'color' => 'bg-green-500']
                    ];
                @endphp

                @foreach ($steps as $step)
                    <x-filament::card class="p-6 w-64 text-center">
                        <div class="mx-auto flex items-center justify-center text-lg font-bold rounded-lg
                                    {{ $step['title'] == $currentRank ? $step['color'] . ' text-white' : 'bg-gray-300' }}">
                            {{ $step['title'] }}
                        </div>
                        <p class="mt-4 text-lg text-gray-700">{{ $step['description'] }}</p>
                    </x-filament::card>
                @endforeach
            </div>
        </div>

        <div class="w-1/2 mx-auto mt-8">
            <h2 class="text-xl font-bold text-center mb-2">Total Delivered Orders: {{$deliveredOrdersCount}}</h2>
            @livewire(\App\Filament\Widgets\StatsDelivered::class)
        <div>
    </div>

    

</x-filament-panels::page>
