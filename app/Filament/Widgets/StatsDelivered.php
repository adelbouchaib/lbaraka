<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Order;

class StatsDelivered extends ChartWidget
{
    protected static ?string $heading = 'Delivered orders per month';

    protected function getData(): array
    {
        $data = Trend::query(
            Order::query()->where('status', 'delivered')->where('approved', 1)
        )
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();
    
        return [
            'datasets' => [
                [
                    'label' => 'Delivered orders',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => ucfirst(\Carbon\Carbon::parse($value->date)->translatedFormat('M'))),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'ticks' => [
                        'beginAtZero' => true,
                        'precision' => 0, // Ensures no decimal values
                        'stepSize' => 1, // Force steps of 1
                    ],
                    'min' => 0, // Ensures there are no negative values
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
