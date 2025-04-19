<?php

namespace App\Filament\Sadmin\Resources;

use App\Filament\Sadmin\Resources\FilachatMessageResource\Pages;
use App\Filament\Sadmin\Resources\FilachatMessageResource\RelationManagers;
use App\Models\FilachatMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


use Filament\Tables\Filters\SelectFilter;

class FilachatMessageResource extends Resource
{
    protected static ?string $model = FilachatMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Textarea::make('message')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('filachat_conversation_id')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('message')
                    ->limit(50)
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('senderable_id')
                    ->formatStateUsing(function ($state) {
                        return \App\Models\User::find($state)?->store?->name ?? \App\Models\User::find($state)?->name  ;
                    })
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('receiverable_id')
                    ->formatStateUsing(function ($state) {
                        return \App\Models\User::find($state)?->store?->name ?? \App\Models\User::find($state)?->name ;
                    })
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('last_read_at')
                    ->dateTime()
                    ->sortable(),
               
               
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
               
            ])
            ->filters([
                //
                SelectFilter::make('filachat_conversation_id')
                    ->label('Conversation')
                    ->options(\App\Models\FilachatConversation::all()->pluck('id', 'id'))
                    ->searchable(),

               

            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()
                  ,
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListFilachatMessages::route('/'),
            // 'create' => Pages\CreateFilachatMessage::route('/create'),
            // 'edit' => Pages\EditFilachatMessage::route('/{record}/edit'),
        ];
    }
}
