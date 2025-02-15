<?php

namespace App\Filament\Buyer\Resources\FavoriteResource\Pages;

use App\Filament\Buyer\Resources\FavoriteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFavorite extends CreateRecord
{
    protected static string $resource = FavoriteResource::class;
}
