<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DigitalProductResource\Pages;
use App\Filament\Admin\Resources\DigitalProductResource\RelationManagers;
use App\Models\DigitalProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;

class DigitalProductResource extends Resource
{
    protected static ?string $model = DigitalProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    
    protected static ?string $navigationLabel = 'Digital Products';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {   
        return $form
            ->schema([
                Tabs::make('Product')->tabs([
                    Tab::make('Basic Information')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', str($state)->slug())),
                                
                            Forms\Components\TextInput::make('slug')
                                ->required()
                                ->maxLength(255)
                                ->unique(DigitalProduct::class, 'slug', ignoreRecord: true),
                                
                            Forms\Components\Select::make('category_id')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                                
                            Forms\Components\TextInput::make('price')
                                ->required()
                                ->numeric()
                                ->prefix('Rp'),
                                
                            Forms\Components\Grid::make()
                                ->schema([
                                    Forms\Components\Toggle::make('is_on_sale')
                                        ->label('On Sale')
                                        ->reactive(),
                                        
                                    Forms\Components\TextInput::make('sale_price')
                                        ->numeric()
                                        ->prefix('Rp')
                                        ->visible(fn (callable $get) => $get('is_on_sale')),
                                        
                                    Forms\Components\DateTimePicker::make('sale_ends_at')
                                        ->label('Sale Ends At')
                                        ->visible(fn (callable $get) => $get('is_on_sale')),
                                ]),
                                
                            Forms\Components\TextInput::make('version')
                                ->maxLength(255),
                                
                            Forms\Components\Grid::make()
                                ->schema([
                                    Forms\Components\Toggle::make('is_active')
                                        ->label('Active')
                                        ->required()
                                        ->default(true),
                                        
                                    Forms\Components\Toggle::make('is_featured')
                                        ->label('Featured')
                                        ->required()
                                        ->default(false),
                                    
                                    Forms\Components\TextInput::make('sort_order')
                                        ->numeric()
                                        ->default(0),
                                ]),
                        ]),
                        
                    Tab::make('Media')
                        ->schema([
                            Forms\Components\FileUpload::make('thumbnail')
                                ->label('Product Thumbnail')
                                ->image()
                                ->required()
                                ->disk('public')
                                ->visibility('public')
                                ->directory('products/thumbnails')
                                ->maxSize(2048)
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                ->helperText('Upload a product thumbnail (Max 2MB, JPEG, PNG, WEBP or GIF)')
                                ->imagePreviewHeight('250')
                                ->loadingIndicatorPosition('left')
                                ->panelAspectRatio('16:9')
                                ->panelLayout('integrated')
                                ->removeUploadedFileButtonPosition('right')
                                ->uploadButtonPosition('left')
                                ->uploadProgressIndicatorPosition('left'),
                                
                            Forms\Components\FileUpload::make('gallery')
                                ->label('Product Gallery')
                                ->multiple()
                                ->image()
                                ->disk('public')
                                ->visibility('public')
                                ->directory('products/gallery')
                                ->maxSize(2048)
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                ->helperText('Upload product gallery images (Max 2MB each, JPEG, PNG, WEBP or GIF)')
                                ->imagePreviewHeight('150')
                                ->loadingIndicatorPosition('left')
                                ->removeUploadedFileButtonPosition('right')
                                ->uploadButtonPosition('left')
                                ->uploadProgressIndicatorPosition('left'),
                        ]),
                        
                    Tab::make('Content')
                        ->schema([
                            Forms\Components\RichEditor::make('description')
                                ->required()
                                ->label('Product Description')
                                ->columnSpanFull(),
                                
                            Forms\Components\RichEditor::make('features')
                                ->label('Product Features')
                                ->columnSpanFull(),
                                
                            Forms\Components\RichEditor::make('requirements')
                                ->label('System Requirements')
                                ->columnSpanFull(),
                        ]),
                        
                    Tab::make('Downloads')
                        ->schema([
                            Forms\Components\TextInput::make('download_url')
                                ->label('Download URL')
                                ->url(),
                                
                            Forms\Components\TextInput::make('demo_url')
                                ->label('Demo URL')
                                ->url(),
                                
                            Forms\Components\TextInput::make('product_type')
                                ->label('Product Type')
                                ->placeholder('e.g., Plugin, Theme, Software')
                                ->required()
                                ->default('Digital Product'),
                        ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\ImageColumn::make('thumbnail_url')
                    ->label('Image')
                    ->circular(false)
                    ->height(40)
                    ->extraAttributes(['class' => 'debug-image'])
                    ->extraImgAttributes(fn ($record) => [
                        'alt' => $record->name,
                        'onerror' => "console.log('Image failed to load: ' + this.src); this.onerror=null; this.src='" . asset('images/placeholder.webp') . "';"
                    ]),
                    
                Tables\Columns\TextColumn::make('category.name')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                    
                Tables\Columns\IconColumn::make('is_on_sale')
                    ->boolean()
                    ->label('On Sale'),
                    
                Tables\Columns\TextColumn::make('sale_price')
                    ->money('IDR')
                    ->sortable()
                    ->visible(fn ($record) => $record && $record->is_on_sale),
                    
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                    
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),
                    
                Tables\Columns\TextColumn::make('version')
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                    
                Tables\Filters\Filter::make('is_active')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true))
                    ->label('Active Products'),
                    
                Tables\Filters\Filter::make('is_featured')
                    ->query(fn (Builder $query): Builder => $query->where('is_featured', true))
                    ->label('Featured Products'),
                    
                Tables\Filters\Filter::make('is_on_sale')
                    ->query(fn (Builder $query): Builder => $query->where('is_on_sale', true))
                    ->label('On Sale'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            RelationManagers\SubscriptionPlansRelationManager::class,
            RelationManagers\LicensesRelationManager::class,
            RelationManagers\ReviewsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDigitalProducts::route('/'),
            'create' => Pages\CreateDigitalProduct::route('/create'),
            'view' => Pages\ViewDigitalProduct::route('/{record}'),
            'edit' => Pages\EditDigitalProduct::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationGroup(): ?string
    {
        return 'Product Management';
    }
}
