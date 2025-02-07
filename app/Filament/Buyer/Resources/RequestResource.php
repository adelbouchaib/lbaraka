<?php

namespace App\Filament\Buyer\Resources;

use App\Filament\Buyer\Resources\RequestResource\Pages;
use App\Filament\Buyer\Resources\RequestResource\RelationManagers;
use App\Models\Request;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;



class RequestResource extends Resource
{
    protected static ?string $model = Request::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Product Information')->schema([

                        Select::make('category_id')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->relationship('category', 'name'), 
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('quantity')
                            ->required()
                            ->numeric(),
                        Forms\Components\MarkdownEditor::make('description')
                            ->columnSpanFull(),
                    ])->columns(3),
                    Section::make('Images')->schema([
                        Forms\Components\FileUpload::make('images')
                            ->multiple()
                            ->directory('requests')
                            ->maxFiles(5)
                            ->reorderable(),
                    ]),

                ])->columnSpan(3),


            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                static::getEloquentQuery()->where('buyer_id', auth()->id())
            )
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                    ->getStateUsing(fn ($record) => $record->images[0] ?? null) // Get the first image
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('chat_nb')
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
            'index' => Pages\ListRequests::route('/'),
            'create' => Pages\CreateRequest::route('/create'),
            'edit' => Pages\EditRequest::route('/{record}/edit'),
        ];
    }
}
