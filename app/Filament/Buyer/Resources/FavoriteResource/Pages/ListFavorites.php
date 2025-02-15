<?php

namespace App\Filament\Buyer\Resources\FavoriteResource\Pages;

use App\Filament\Buyer\Resources\FavoriteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFavorites extends ListRecords
{
    protected static string $resource = FavoriteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
