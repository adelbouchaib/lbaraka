<?php

namespace App\Filament\Buyer\Resources;

use App\Filament\Buyer\Resources\ProductResource\Pages;
use App\Filament\Buyer\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;



class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Product Information')->schema([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255),

                            Select::make('category_id')
                                ->required()
                                ->searchable()
                                ->preload()
                                ->relationship('category', 'name'),                        

                            Forms\Components\MarkdownEditor::make('description')
                                ->columnSpanFull(),
                    ])->columns(2),

                    Section::make('Images')->schema([
                        Forms\Components\FileUpload::make('images')
                            ->multiple()
                            ->directory('products')
                            ->maxFiles(5)
                            ->reorderable()
                    ]),

                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make('Price')->schema([
                        
                        Forms\Components\TextInput::make('price')
                        ->required()
                        ->numeric()
                        ->prefix('DZD'),

                        Forms\Components\TextInput::make('quantity')
                        ->required()
                        ->numeric(),
                    ]),
        

                    Section::make('Status')->schema([
                        Forms\Components\Checkbox::make('is_active')
                            ->required()
                            ->default(true),
                        Forms\Components\Checkbox::make('in_stock')
                            ->required()
                            ->default(true),
                    ]),

                ])->columnSpan(1),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('images')
                    ->getStateUsing(fn ($record) => $record->images[0] ?? null) // Get the first image
                    ->circular(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('in_stock')
                    ->boolean(),
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
                SelectFilter::make('category')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
