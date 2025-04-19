<?php

namespace App\Filament\Sadmin\Resources\FilachatMessageResource\Pages;

use App\Filament\Sadmin\Resources\FilachatMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFilachatMessages extends ListRecords
{
    protected static string $resource = FilachatMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
