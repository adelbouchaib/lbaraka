<?php

namespace App\Filament\Sadmin\Resources\FavoriteResource\Pages;

use App\Filament\Sadmin\Resources\FavoriteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFavorite extends CreateRecord
{
    protected static string $resource = FavoriteResource::class;
}
