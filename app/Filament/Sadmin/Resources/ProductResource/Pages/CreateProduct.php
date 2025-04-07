<?php

namespace App\Filament\Sadmin\Resources\ProductResource\Pages;

use App\Filament\Sadmin\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
}
