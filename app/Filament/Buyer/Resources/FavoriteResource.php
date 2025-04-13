<?php

namespace App\Filament\Buyer\Resources;

use App\Filament\Buyer\Resources\FavoriteResource\Pages;
use App\Filament\Buyer\Resources\FavoriteResource\RelationManagers;
use App\Models\Favorite;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
// use App\Models\Product;
use Filament\Tables\Actions\ViewAction;

use Filament\Tables\Filters\SelectFilter;



class FavoriteResource extends Resource
{
    protected static ?string $model = Favorite::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('product_id')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
       
            ->columns([
                ImageColumn::make('product.images')
                    ->getStateUsing(fn ($record) => $record->product->images[0] ?? null) // Get the first image
                    ->label('Product')
                    ->size(100), // Optional: Makes the image round
                TextColumn::make('product.name')
                    ->extraAttributes(['class' => 'font-arabic'])
                    ->searchable()
                    ->label('Name'),
                Tables\Columns\TextColumn::make('product.price')
                    ->formatStateUsing(fn ($state) => number_format($state, 0) . ' DZD')
                    ->label('Price')
                    ->sortable(),
                Tables\Columns\IconColumn::make('product.is_active')
                    ->label('Available')
                    ->sortable()
                    ->falseIcon('heroicon-o-clock')
                    ->trueIcon('heroicon-o-check-circle')
                    ->color(fn ($state) => $state ? 'success' : 'warning')
                    ->boolean(), // Custom icon when inactive
                Tables\Columns\TextColumn::make('created_at')
                    ->formatStateUsing(fn ($state) => \Illuminate\Support\Carbon::parse($state)->diffForHumans())
                    ->label("Created")
    
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')

            ->filters([
            //
                    
            ])
            ->actions([
                ViewAction::make('view')
                // ->requiresConfirmation()
                ->url(fn (Favorite $record) => url("/products/{$record->product->slug}")) // Generates the correct URL
                , 
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListFavorites::route('/'),
            'create' => Pages\CreateFavorite::route('/create'),
            'edit' => Pages\EditFavorite::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('buyer_id', auth()->id());
    }
}
