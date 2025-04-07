<?php

namespace App\Filament\Sadmin\Resources;

use App\Filament\Sadmin\Resources\SellerLeadResource\Pages;
use App\Filament\Sadmin\Resources\SellerLeadResource\RelationManagers;
use App\Models\SellerLead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SellerLeadResource extends Resource
{
    protected static ?string $model = SellerLead::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('business_type')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('business_wilaya')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('business_delivery')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('business_products')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('products_type')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('business_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('business_wilaya')
                    ->searchable(),
                Tables\Columns\TextColumn::make('business_delivery')
                    ->searchable(),
                Tables\Columns\TextColumn::make('business_products')
                    ->searchable(),
                Tables\Columns\TextColumn::make('products_type')
                    ->searchable(),
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
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSellerLeads::route('/'),
            'create' => Pages\CreateSellerLead::route('/create'),
            'edit' => Pages\EditSellerLead::route('/{record}/edit'),
        ];
    }
}
