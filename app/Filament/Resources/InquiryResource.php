<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InquiryResource\Pages;
use App\Filament\Resources\InquiryResource\RelationManagers;
use App\Models\Inquiry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\FilachatMessage;

class InquiryResource extends Resource
{
    protected static ?string $model = Inquiry::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getNavigationLabel(): string
    {
        return __('Inquiries'); // Change Dashboard name
    }

    public static function getLabel(): string
    {
        return __('Inquirie'); // Change Dashboard name
    }

    public static function getPluralModelLabel(): string
    {
        return __('Inquiries');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('buyer')
                    ->formatStateUsing(fn ($record) => $record?->buyer?->name) // Display product name
                    ->disabled(), // Prevent user edits
                Forms\Components\TextInput::make('product')
                    ->extraAttributes(['class' => 'font-arabic'])
                    ->formatStateUsing(fn ($record) => $record?->product?->name) // Display product name
                    ->disabled(), // Prevent user edits
               
                Forms\Components\Textarea::make('message')
                    ->formatStateUsing(fn ($record) => 
                        strip_tags(nl2br(preg_replace('/^.*?message:/i', '', $record?->message->message ?? '')))
                    ) 
                    ->disabled(),
                
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('product.images')
                    ->translateLabel()
                    ->getStateUsing(fn ($record) => $record->product->images[0] ?? null) // Get the first image
                    ->size(80),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Name')
                    ->searchable()
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                ->translateLabel()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->translateLabel()
                    ->badge() // Enables the badge style
                    ->formatStateUsing(function ($state, $record) {
                        // Get the last message sent by the authenticated user in this conversation
                        $lastMessage = FilachatMessage::where('filachat_conversation_id', $record->conversation->id)
                            ->where('senderable_id', auth()->id())
                            ->latest('created_at')
                            ->first();
                
                        // Check if the inquiry message is older than the last message sent
                        $hasReply = $record->message->id < optional($lastMessage)->id;
                
                        // Change the status based on the condition
                        return $hasReply ? __('Replied') : __('Pending');
                    })
                    ->color(function ($state) {
                        return $state === 'Replied' ? 'success' : 'warning';
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('buyer.name')
                    ->searchable()
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                ->translateLabel()
                ->formatStateUsing(fn ($state) => \Illuminate\Support\Carbon::parse($state)->diffForHumans())
                ->sortable(),
               
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),

                Tables\Actions\Action::make('chat')
                ->label('Chat') // Set the button 
                ->translateLabel()
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->url(fn (Inquiry $record) => url("/seller/filachat/{$record->filachat_conversation_id}"))
                ->openUrlInNewTab()
                ->color('primary'),
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
            'index' => Pages\ListInquiries::route('/'),
            'create' => Pages\CreateInquiry::route('/create'),
            'edit' => Pages\EditInquiry::route('/{record}/edit'),
        ];
    }

    public static function getNavigationSort(): int
    {
        return 2; // Lower number = higher priority
    }
}
