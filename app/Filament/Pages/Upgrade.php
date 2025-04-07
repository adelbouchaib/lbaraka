<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Upgrade extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.upgrade';

    protected static bool $shouldRegisterNavigation = false;

}
