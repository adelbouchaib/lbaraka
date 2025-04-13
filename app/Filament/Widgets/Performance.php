<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use App\Models\Order;
use App\Models\FilachatConversation;
use App\Models\Product;
use App\Models\Inquiry;

class Performance extends BaseWidget
{
    protected function getStats(): array
    {
        $inquiryCount = Inquiry::whereHas('conversation', function ($query) {
            $query->where('receiverable_id', auth()->id())
                  ->orWhere('senderable_id', auth()->id());
        })->count();
        
        $orderCount = Order::where('seller_id', auth()->id())->count();

        $deliveredCount = Order::where('seller_id', auth()->id())
        ->where('status', 'delivered')
        ->count();

        return [
            Stat::make('Inquiries', Inquiry::whereHas('conversation', function ($query) {
                $query->where('receiverable_id', auth()->id())
                      ->orWhere('senderable_id', auth()->id());
            })->count())   
            ->label(__('Inquiries'))       
                ->color('success'),

            Stat::make('Orders', Order::where('seller_id', auth()->id())->count())
                ->color('success')
                ->label(__('Orders'))       
                ->description($inquiryCount > 0 ? round(($orderCount / $inquiryCount) * 100, 2) . __('% conversion') : __('No inquiries yet'))
                ->descriptionIcon('heroicon-m-arrow-trending-up'),

            Stat::make('Delivered Orders', Order::where('seller_id', auth()->id())
                ->where('status', 'delivered')
                ->count())
            ->color('success')
            ->label(__('Delivered Orders'))       
            ->description($orderCount > 0 ? round(($deliveredCount / $orderCount) * 100, 2) . __('% conversion') : __('No inquiries yet'))
            ->descriptionIcon('heroicon-m-arrow-trending-up'),
                
        ];
    }
}
