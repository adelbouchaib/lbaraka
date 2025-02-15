<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                Section::make('Order information')->schema([

                Forms\Components\TextInput::make('id')
                ->disabled(),

                Forms\Components\Select::make('buyer_id')
                ->label('Buyer')
                ->options(\App\Models\Inquiry::with('buyer')->get()->pluck('buyer.name', 'buyer.id')->toArray()) // Fetch buyer name from related User
                ->searchable() // Allows search in dropdown
                ->default(fn () => \App\Models\Inquiry::with('buyer')->first()?->buyer?->id) // Set default
                ->required(),
                
                Forms\Components\ToggleButtons::make('status')
                ->inline()
                ->options([
                    'Pending' => 'Pending',
                    'Delivered' => 'Delivered',
                    'Cancelled' => 'Cancelled',
                ])
                ->icons([
                        'Pending' => 'heroicon-o-clock',
                        'Delivered' => 'heroicon-o-check-circle',
                        'Cancelled' => 'heroicon-o-x-circle',
                ])
                ->colors([
                        'Pending' => 'warning',
                        'Delivered' => 'success',
                        'Cancelled' => 'danger',
                ])
                ->default(fn ($record) => $record?->status ?? 'pending') // Fetch from DB, default to 'pending'
                ->columnSpanFull()
                ->live() // Important: Ensures real-time updates
                ->required(), 

                Forms\Components\FileUpload::make('delivery_receipt')
                    ->label('Upload Delivery Receipt')
                    ->visible(fn ($get) => $get('status') === 'Delivered') // Show only if 'Delivered' is selected
                    ->multiple()
                    ->maxFiles(5)
                    ->reorderable()
                    ->directory('receipts') // Folder where files are stored
                    ->columnSpanFull(),
                ])->columns(2),

                Section::make('Product')->schema([
                    Forms\Components\Select::make('product_id') // Use 'product_id' since it stores the actual ID
                    ->label('Product')
                    ->options(\App\Models\Inquiry::with('product')->get()->pluck('product.name', 'product.id')->toArray()) // Ensure it's an array
                    ->searchable()
                    ->default(fn () => \App\Models\Inquiry::with('product')->first()?->product?->id) // Set default
                    ->required(),
    
                    Forms\Components\TextInput::make('quantity')
                    ->numeric(),
    
                    Forms\Components\TextInput::make('total_price')
                    ->numeric(),
               
                ])->columns(3),

            ])->columnSpan(2),

            Group::make()->schema([

                Section::make()->schema([
                    Forms\Components\Placeholder::make('created_at')
                        ->label('Created at')
                        ->content(fn (Order $record): ?string => $record->created_at?->diffForHumans()),

                    Forms\Components\Placeholder::make('updated_at')
                        ->label('Last modified at')
                        ->content(fn (Order $record): ?string => $record->updated_at?->diffForHumans()),
                ]),


            
                ])->columnSpan(1),

                
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->query(
                static::getEloquentQuery()->where('seller_id', auth()->id())
                ->with(['product']) // Load relationships
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                ->sortable(),
                Tables\Columns\TextColumn::make('buyer.name')
                ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->icon(fn ($state) => match ($state) {
                        'Pending' => 'heroicon-o-truck',
                        'Delivered' => 'heroicon-o-check-circle',
                        'Cancelled' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->color(fn ($state) => match ($state) {
                        'Pending' => 'warning',
                        'Delivered' => 'success',
                        'Cancelled' => 'danger',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('approved')
                ->badge()
                ->icon(fn ($record) => match (true) {
                    $record->status === 'Pending' && $record->approved === 0 => 'heroicon-o-clock',  // ❌ Pending & not approved
                    $record->status === 'Delivered' && $record->approved === 1 => 'heroicon-o-check-circle', // ✅ Delivered & approved
                    $record->status === 'Delivered' && $record->approved === 0 => 'heroicon-o-clock', // ✅ Delivered & approved
                    default => 'heroicon-o-check-circle' // ❓ Default case (unknown status)
                })
                ->color(fn ($record) => match (true) {
                    $record->status === 'Pending' && $record->approved === 0 => 'warning',  // ❌ Pending & not approved
                    $record->status === 'Delivered' && $record->approved === 1 => 'success', // ✅ Delivered & approved
                    $record->status === 'Delivered' && $record->approved === 0 => 'warning', // ✅ Delivered & approved
                    default => 'success' // ❓ Default case (unknown status)
                })
                ->formatStateUsing(fn ($record) => match (true) {
                    $record->status === 'Pending' && $record->approved === 0 => 'In delivery',  // ❌ Pending & not approved
                    $record->status === 'Delivered' && $record->approved === 1 => 'Approved', // ✅ Delivered & approved
                    $record->status === 'Delivered' && $record->approved === 0 => 'Pending', // ✅ Delivered & approved
                    default => 'Approved' // ❓ Default case (unknown status)
                }),
                
               
                Tables\Columns\TextColumn::make('product.name')
                    ->limit(40)
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
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

    public static function getNavigationSort(): int
    {
        return 3; // Lower number = higher priority
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
