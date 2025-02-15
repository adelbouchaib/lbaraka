<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Inquiry;

class Stats extends ChartWidget
{
    protected static ?string $heading = 'Inquiries per month';

    protected function getData(): array
    {
        $data = Trend::model(Inquiry::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();
    
        return [
            'datasets' => [
                [
                    'label' => 'Inquiries',
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
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
