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
                    ->label('Product Image')
                    ->size(100), // Optional: Makes the image round
                TextColumn::make('product.name')
                    ->searchable()
                    ->label('Product Name'),
                Tables\Columns\TextColumn::make('product.price')
                    ->formatStateUsing(fn ($state) => number_format($state, 2) . ' DA')
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.moq')
                    ->sortable(),
                Tables\Columns\IconColumn::make('product.is_active')
                    ->sortable()
                    ->label('Available')
                    ->falseIcon('heroicon-o-clock')
                    ->trueIcon('heroicon-o-check-circle')
                    ->color(fn ($state) => $state ? 'success' : 'warning')
                    ->boolean(), // Custom icon when inactive
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                ViewAction::make('view')
                // ->requiresConfirmation()
                ->url(fn (Favorite $record) => url("/products/{$record->product->slug}")) // Generates the correct URL
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
            'index' => Pages\ListFavorites::route('/'),
            'create' => Pages\CreateFavorite::route('/create'),
            'edit' => Pages\EditFavorite::route('/{record}/edit'),
        ];
    }
}
