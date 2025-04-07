<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoreResource\Pages;
use App\Filament\Resources\StoreResource\RelationManagers;
use App\Models\Store;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Filament\Forms\Components\Select;
use App\Models\Product;
use Filament\Tables\Actions\ViewAction;



class StoreResource extends Resource
{
    protected static ?string $model = Store::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return __('Store'); // Change Dashboard name
    }

    public static function getLabel(): string
    {
        return __('Store'); // Change Dashboard name
    }

    public static function getPluralModelLabel(): string
    {
        return __('Store');
    }

    public static function getNavigationBadge(): ?string
    {
        if (Auth::user()->type === 'individual') {
            return __('تحتاج ترقية لحسابك');
        }
        else{
            return null;
        }
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                // Forms\Components\TextInput::make('name')
                //     ->required()
                //     ->translateLabel()
                //     ->maxLength(255),
                Forms\Components\Select::make('featured_products')
                    ->options(Product::all()->pluck('name', 'id')) // Assuming you have a 'name' and 'id' in Product model
                    ->multiple()
                    ->maxItems(4)
                    ->translateLabel()
                    ->label('Select main products'),
                // Forms\Components\FileUpload::make('logo')
                //     ->required()
                //     ->translateLabel()
                //     ->directory('stores'),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->getStateUsing(fn ($record) => $record->logo ?? null) // Get the first image
                    ->label(__('Store'))
                    ->size(100),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ,
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                ViewAction::make('view')
                    // ->requiresConfirmation()
                    ->url(fn (Store $record) => url("/stores/{$record->slug}")) // Generates the correct URL
                    ->openUrlInNewTab(), // Optional: Opens in a new tab
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStores::route('/'),
            'create' => Pages\CreateStore::route('/create'),
            'edit' => Pages\EditStore::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('seller_id', auth()->id());
    }
  
}
