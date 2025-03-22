<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CategoryResource\Pages;
use App\Filament\Admin\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    
    protected static ?string $navigationLabel = 'Kategori';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', str($state)->slug())),
                            
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(Category::class, 'slug', ignoreRecord: true),
                            
                        Forms\Components\RichEditor::make('description')
                            ->label('Category Description')
                            ->columnSpanFull(),
                    ]),
                
                Forms\Components\Section::make('Media & Settings')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Category Image')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('categories')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                            ->helperText('Upload a category image (Max 2MB, JPEG, PNG, WEBP or GIF)')
                            ->imagePreviewHeight('250')
                            ->loadingIndicatorPosition('left')
                            ->panelAspectRatio('16:9')
                            ->panelLayout('integrated')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left'),
                            
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->required()
                            ->default(true),
                            
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->helperText('Lower numbers appear first')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Image')
                    ->circular(false)
                    ->height(40)
                    ->extraAttributes(['class' => 'debug-image'])
                    ->extraImgAttributes(fn ($record) => [
                        'alt' => $record->name,
                        'onerror' => "console.log('Image failed to load: ' + this.src); this.onerror=null; this.src='" . asset('images/placeholder.webp') . "';"
                    ]),
                    
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('digitalProducts_count')
                    ->counts('digitalProducts')
                    ->label('Digital Products')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_active')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true))
                    ->label('Active Categories'),
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
            RelationManagers\DigitalProductsRelationManager::class,
            RelationManagers\ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'view' => Pages\ViewCategory::route('/{record}'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Products';
    }
}
