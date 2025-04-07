<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
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

use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Auth;



class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    public static function getNavigationLabel(): string
    {
        return __('Products'); // Change Dashboard name
    }

    public static function getLabel(): string
    {
        return __('Product'); // Change Dashboard name
    }

    public static function getPluralModelLabel(): string
    {
        return __('Products');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make(__('Product Information'))->schema([
                            TextInput::make('name')
                                ->translateLabel()
                                ->required()
                                ->maxLength(255),

                            Select::make('category_id')
                                ->required()
                                ->translateLabel()
                                ->searchable()
                                ->preload()
                                ->relationship('category', 'name'),                        

                                // Forms\Components\MarkdownEditor::make('description')
                                // RichEditor::make('description')

                                // Textarea::make('short_description')
                                // ->translateLabel()
                               
                                //     ->columnSpanFull(),

                            RichEditor::make('description')
                            ->translateLabel()
                                ->columnSpanFull(),
                    ])->columns(2),

                    Section::make(__('Images'))->schema([
                        Forms\Components\FileUpload::make('images')
                            ->multiple()
                            ->required()
                            ->translateLabel()
                            ->directory('products')
                            ->maxFiles(5)
                            ->reorderable()
                    ]),

                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make(__('Price'))->schema([
                        
                        Forms\Components\TextInput::make('price')
                        ->translateLabel()
                        ->required()
                        ->numeric()
                        ->prefix('DZD'),

                        Forms\Components\TextInput::make('moq')
                        ->label('Minimum quantity')
                        ->default(10)
                        ->translateLabel()
                        ->required()
                        ->numeric(),
                    ]),
        

                    Section::make(__('Status'))->schema([
                        Forms\Components\Toggle::make('is_active')
                        ->label('Active') // Optional: Customize label
                        ->translateLabel()
                        ->required()
                        ->default(true) // Default checked (true)
                    ]),

                ])->columnSpan(1),

            ])->columns(3);

          
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                    ->getStateUsing(fn ($record) => $record->images[0] ?? null) // Get the first image
                    ->label(__('Product'))
                    ->size(80),
                Tables\Columns\TextColumn::make('name')
                    ->translateLabel()
                    ->limit(40)
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->formatStateUsing(fn ($state) => number_format($state, 2) .  __(' DA'))
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\TextColumn::make('moq')
                    ->label(__('Min. quantity'))
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Available') // Optional label
                    ->translateLabel()
                    ->sortable()
                    ->onIcon('heroicon-o-check') // Custom icon when active
                    ->offIcon('heroicon-o-x-circle'), // Custom icon when inactive
                Tables\Columns\IconColumn::make('is_approved')
                    ->label('Approved') // Optional label
                    ->translateLabel()
                    ->sortable()
                    ->falseIcon('heroicon-o-clock')
                    ->trueIcon('heroicon-o-check-circle')
                    ->color(fn ($state) => $state ? 'success' : 'warning')
                    ->boolean(), // Custom icon when inactive
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->formatStateUsing(fn ($state) => \Illuminate\Support\Carbon::parse($state)->diffForHumans())
                    ->translateLabel()

                    ->sortable(),
            
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('category')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                ViewAction::make('view')
                    // ->requiresConfirmation()
                    ->url(fn (Product $record) => url("/products/{$record->slug}")) // Generates the correct URL
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

    public static function getNavigationSort(): int
    {
        return 0; // Lower number = higher priority
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('seller_id', auth()->id());
    }

}
