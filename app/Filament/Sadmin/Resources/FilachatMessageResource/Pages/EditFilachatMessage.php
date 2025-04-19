<?php

namespace App\Filament\Sadmin\Resources\FilachatMessageResource\Pages;

use App\Filament\Sadmin\Resources\FilachatMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFilachatMessage extends EditRecord
{
    protected static string $resource = FilachatMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
