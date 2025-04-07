<?php

namespace App\Filament\Sadmin\Resources\SellerLeadResource\Pages;

use App\Filament\Sadmin\Resources\SellerLeadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSellerLead extends EditRecord
{
    protected static string $resource = SellerLeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
