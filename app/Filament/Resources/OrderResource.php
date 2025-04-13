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

    public static function getNavigationLabel(): string
    {
        return __('Orders'); // Change Dashboard name
    }

    public static function getLabel(): string
    {
        return __('Order'); // Change Dashboard name
    }

    public static function getPluralModelLabel(): string
    {
        return __('Orders');
    }




    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                Section::make(__('Order information'))->schema([

                Forms\Components\TextInput::make('id')
                ->translateLabel()
                ->disabled(),

                Forms\Components\Select::make('buyer_id')
                ->label('Buyer')
                ->translateLabel()
                ->options(\App\Models\Inquiry::with('buyer')->get()->pluck('buyer.name', 'buyer.id')->toArray()) // Fetch buyer name from related User
                ->searchable() // Allows search in dropdown
                ->default(fn () => \App\Models\Inquiry::with('buyer')->first()?->buyer?->id) // Set default
                ->required(),
                
                Forms\Components\ToggleButtons::make('status')
                ->translateLabel()
                ->inline()
                ->options([
                   'Pending' =>  __('Pending'),
                    'Delivered' => __('Delivered'),
                    'Cancelled' => __('Cancelled'),
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


                ])->columns(2),

                Section::make(__('Product'))->schema([
                    Forms\Components\Select::make('product_id') // Use 'product_id' since it stores the actual ID
                    ->label('Product')
                    ->translateLabel()
                    ->options(\App\Models\Inquiry::with('product')->get()->pluck('product.name', 'product.id')->toArray()) // Ensure it's an array
                    ->searchable()
                    ->default(fn () => \App\Models\Inquiry::with('product')->first()?->product?->id) // Set default
                    ->required(),
    
                    Forms\Components\TextInput::make('quantity')
                    ->translateLabel()
                    ->numeric(),
    
                    Forms\Components\TextInput::make('total_price')
                    ->translateLabel()
                    ->numeric(),
               
                ])->columns(3),

            ])->columnSpan(2),

            Group::make()->schema([

                Section::make()->schema([
                    Forms\Components\Placeholder::make('created_at')
                        ->label('Created at')
                        ->translateLabel()
                        ->content(fn (Order $record): ?string => $record->created_at?->diffForHumans()),

                    Forms\Components\Placeholder::make('updated_at')
                        ->label('Last modified at')
                        ->translateLabel()
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
                ->translateLabel()
                ->formatStateUsing(fn ($state) => '#' . $state)
                ->sortable(),
                Tables\Columns\TextColumn::make('buyer.name')
                ->translateLabel()
                ->sortable(),
                Tables\Columns\TextColumn::make('status')
                ->translateLabel()

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
                    ->formatStateUsing(fn ($record) => match (true) {
                        $record->status === 'Pending' => __('Pending'),  // ❌ Pending & not approved
                        $record->status === 'Delivered' => __('Delivered'), // ✅ Delivered & approved
                        $record->status === 'Cancelled' => __('Cancelled'), // ✅ Delivered & approved
                        default => 'Pending' // ❓ Default case (unknown status)
                    })
                    ->searchable(),
                
                
               
                Tables\Columns\TextColumn::make('product.name')
                ->translateLabel()
                    ->limit(40)
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                ->translateLabel()
                ->formatStateUsing(fn ($state) => \Illuminate\Support\Carbon::parse($state)->diffForHumans())
                    // ->date()
                    ->sortable(),
                
            ])
            ->defaultSort('created_at', 'desc')
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('seller_id', auth()->id());
    }
}
