<?php

namespace App\Filament\Sadmin\Resources\UserResource\Pages;

use App\Filament\Sadmin\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
