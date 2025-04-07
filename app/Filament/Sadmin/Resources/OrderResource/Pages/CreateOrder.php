<?php

namespace App\Filament\Sadmin\Resources\OrderResource\Pages;

use App\Filament\Sadmin\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
