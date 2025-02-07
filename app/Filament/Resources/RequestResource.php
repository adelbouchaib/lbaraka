<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestResource\Pages;
use App\Filament\Resources\RequestResource\RelationManagers;
use App\Models\Request;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Select;
use Filament\Tables\Actions\Action;
use App\Models\FilachatConversation;
use App\Models\FilachatMessage;
use Filament\Tables\Columns\Layout\Grid;




class RequestResource extends Resource
{
    public ?int $newRowId = null; // Property to store ID

    protected static ?string $model = Request::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('category_id')
                ->required()
                ->searchable()
                ->preload()
                ->relationship('category', 'name'), 
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\FileUpload::make('images')
                ->multiple()
                ->directory('requests')
                ->maxFiles(5)
                ->reorderable(),
            Forms\Components\MarkdownEditor::make('description')
                ->columnSpanFull(),
            Forms\Components\TextInput::make('quantity')
                ->required()
                ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Grid::make()
                ->columns(1)
                ->schema([
                    Tables\Columns\ImageColumn::make('images')
                        ->getStateUsing(fn ($record) => $record->images[0] ?? null) // Get the first image
                        ->size(320),
                    Tables\Columns\TextColumn::make('name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('quantity')
                        ->numeric()
                        ->sortable(),
                ]),
            ])
            ->contentGrid(['md'=> 2, 'xl' => 3])
            ->paginationPageOptions([9, 18, 27])
            ->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('customAction')
                    ->label('Chat') // Set the button label
                    ->color('primary') // Set button color
                    ->button()
                    ->action(fn ($record) => app(\App\Filament\Resources\RequestResource::class)->createRow($record->buyer_id, $record->id))
                    ])            
            ->bulkActions([
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

    
    public $product; // This will hold the product data
    public $showModal = false;
    public $message = '';
    public $sellerId;


    public function createRow($seller_id, $request_id)
    {
        $authenticatedBuyerId = auth()->id();
        $existingConversation = FilachatConversation::where(function($query) use($authenticatedBuyerId, $seller_id){
            $query->where('senderable_id', $authenticatedBuyerId)
                ->where('receiverable_id', $seller_id);
        })->orWhere(function($query) use($authenticatedBuyerId, $seller_id){
            $query->where('senderable_id', $seller_id)
                ->where('receiverable_id', $authenticatedBuyerId);
        })->first();

        if($existingConversation){
            $request = Request::find($request_id);
            $existingConversation->requests()->syncWithoutDetaching($request);

            return redirect()->to('admin/filachat/' . $existingConversation->id);
        } 

        $row = FilachatConversation::create([
            'senderable_id' => auth()->id(),
            'senderable_type' => 'App\Models\User',
            'receiverable_id' => $seller_id,
            'receiverable_type' => 'App\Models\User'
        ]);

        FilachatMessage::create([
            'filachat_conversation_id' => $row->id,
            'message' => "Request " . $row->id,
            'senderable_id' => auth()->id(),
            'senderable_type' => 'App\Models\User',
            'receiverable_id' => $seller_id,
            'receiverable_type' => 'App\Models\User'
        ]);

        $request = Request::find($request_id);
        $existingConversation->requests()->syncWithoutDetaching($request);
    

        return redirect()->to('admin/filachat/' . $row->id);
    

    }



}
