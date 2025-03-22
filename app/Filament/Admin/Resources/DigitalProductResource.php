<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DigitalProductResource\Pages;
use App\Filament\Admin\Resources\DigitalProductResource\RelationManagers;
use App\Models\DigitalProduct;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Actions\Action;
use Filament\Support\Enums\ActionSize;

class DigitalProductResource extends Resource
{
    protected static ?string $model = DigitalProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    
    protected static ?string $navigationLabel = 'Produk Digital';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {   
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Informasi Dasar')
                        ->icon('heroicon-o-information-circle')
                        ->description('Informasi utama produk digital')
                        ->schema([
                            Group::make()
                                ->schema([
                                    Section::make('Detail Produk')
                                        ->description('Informasi dasar tentang produk digital')
                                        ->schema([
                                            Forms\Components\TextInput::make('name')
                                                ->required()
                                                ->maxLength(255)
                                                ->live(onBlur: true)
                                                ->label('Nama Produk')
                                                ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', str($state)->slug())),
                                                
                                            Forms\Components\TextInput::make('slug')
                                                ->required()
                                                ->maxLength(255)
                                                ->label('Slug URL')
                                                ->helperText('URL produk akan menjadi: yourdomain.com/products/[slug]')
                                                ->unique(DigitalProduct::class, 'slug', ignoreRecord: true),
                                                
                                            Forms\Components\Select::make('category_id')
                                                ->relationship('category', 'name')
                                                ->label('Kategori')
                                                ->searchable()
                                                ->preload()
                                                ->required(),
                                                
                                            Forms\Components\TextInput::make('version')
                                                ->maxLength(255)
                                                ->label('Versi')
                                                ->helperText('Opsional - versi produk saat ini (contoh: 1.0.0)'),
                                                
                                            Forms\Components\TextInput::make('product_type')
                                                ->label('Tipe Produk')
                                                ->placeholder('e.g., Plugin, Theme, Software')
                                                ->required()
                                                ->default('Digital Product'),
                                        ])->columns(2),
                                        
                                    Section::make('Status Produk')
                                        ->schema([
                                            Forms\Components\Grid::make(3)
                                                ->schema([
                                                    Forms\Components\Toggle::make('is_active')
                                                        ->label('Aktif')
                                                        ->helperText('Apakah produk ini aktif dan dapat dibeli?')
                                                        ->required()
                                                        ->default(true),
                                                        
                                                    Forms\Components\Toggle::make('is_featured')
                                                        ->label('Direkomendasikan')
                                                        ->helperText('Apakah produk ini ditampilkan di bagian rekomendasi?')
                                                        ->required()
                                                        ->default(false),
                                                    
                                                    Forms\Components\TextInput::make('sort_order')
                                                        ->numeric()
                                                        ->default(0)
                                                        ->label('Urutan Tampilan')
                                                        ->helperText('Produk dengan nilai lebih rendah tampil lebih dulu'),
                                                ]),
                                        ]),
                                ])->columnSpan(2),
                                
                            Group::make()
                                ->schema([
                                    Section::make('Preview Produk')
                                        ->description('Bagaimana produk ini akan ditampilkan di halaman utama')
                                        ->schema([
                                            Forms\Components\Placeholder::make('preview')
                                                ->content(function (Forms\Get $get) {
                                                    return view('components.admin.product-preview-card', [
                                                        'name' => $get('name') ?: 'Nama Produk',
                                                        'price' => $get('price') ? 'Rp ' . number_format($get('price'), 0, ',', '.') : 'Rp 0',
                                                        'isOnSale' => $get('is_on_sale'),
                                                        'salePrice' => $get('sale_price') ? 'Rp ' . number_format($get('sale_price'), 0, ',', '.') : '',
                                                        'discount' => $get('is_on_sale') && $get('price') && $get('sale_price') 
                                                            ? round((($get('price') - $get('sale_price')) / $get('price')) * 100) . '%' 
                                                            : '0%',
                                                    ]);
                                                })
                                        ])
                                ])->columnSpan(1),
                        ])->columns(3),
                        
                    Step::make('Harga')
                        ->icon('heroicon-o-currency-dollar')
                        ->description('Harga dan diskon produk')
                        ->schema([
                            Section::make('Informasi Harga')
                                ->description('Atur harga dan diskon untuk produk ini')
                                ->schema([
                                    Forms\Components\TextInput::make('price')
                                        ->required()
                                        ->numeric()
                                        ->prefix('Rp')
                                        ->label('Harga Normal')
                                        ->helperText('Masukkan harga normal produk')
                                        ->live(),
                                        
                                    Forms\Components\Toggle::make('is_on_sale')
                                        ->label('Sedang Diskon')
                                        ->helperText('Aktifkan jika produk sedang dalam masa promosi')
                                        ->reactive()
                                        ->live(),
                                        
                                    Forms\Components\Grid::make()
                                        ->schema([
                                            Forms\Components\TextInput::make('sale_price')
                                                ->numeric()
                                                ->prefix('Rp')
                                                ->label('Harga Promosi')
                                                ->helperText('Harga setelah diskon')
                                                ->visible(fn (Forms\Get $get) => $get('is_on_sale'))
                                                ->live()
                                                ->requiredIf('is_on_sale', true),
                                                
                                            Forms\Components\Placeholder::make('discount_percentage')
                                                ->label('Persentase Diskon')
                                                ->content(function (Forms\Get $get) {
                                                    $price = (float) $get('price');
                                                    $salePrice = (float) $get('sale_price');
                                                    
                                                    if ($get('is_on_sale') && $price > 0 && $salePrice > 0 && $salePrice < $price) {
                                                        $discount = round((($price - $salePrice) / $price) * 100);
                                                        return "<span class='text-success-500 font-medium'>{$discount}% OFF</span>";
                                                    }
                                                    
                                                    return '0%';
                                                })
                                                ->visible(fn (Forms\Get $get) => $get('is_on_sale')),
                                                
                                            Forms\Components\DateTimePicker::make('sale_ends_at')
                                                ->label('Promosi Berakhir Pada')
                                                ->helperText('Kosongkan jika tidak ada batas waktu')
                                                ->visible(fn (Forms\Get $get) => $get('is_on_sale')),
                                        ])->columns(2),
                                ])->columnSpan(2),
                                
                            Group::make()
                                ->schema([
                                    Section::make('Rekomendasi Subscription Plan')
                                        ->description('Setelah menyimpan produk, Anda dapat membuat Subscription Plan')
                                        ->schema([
                                            Forms\Components\Placeholder::make('subscription_note')
                                                ->content('Untuk menambahkan paket langganan (subscription plan) dengan beragam durasi dan fitur, silahkan simpan produk terlebih dahulu. Kemudian Anda dapat menambahkan subscription plan dari halaman detail produk.')
                                        ])
                                ])->columnSpan(1),
                        ])->columns(3),
                        
                    Step::make('Media')
                        ->icon('heroicon-o-photo')
                        ->description('Gambar dan visual produk')
                        ->schema([
                            Forms\Components\FileUpload::make('thumbnail')
                                ->label('Thumbnail Produk')
                                ->image()
                                ->required()
                                ->disk('public')
                                ->visibility('public')
                                ->directory('products/thumbnails')
                                ->maxSize(2048)
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                ->helperText('Upload thumbnail produk (Max 2MB, JPEG, PNG, WEBP atau GIF)')
                                ->imagePreviewHeight('250')
                                ->loadingIndicatorPosition('left')
                                ->panelAspectRatio('16:9')
                                ->panelLayout('integrated')
                                ->removeUploadedFileButtonPosition('right')
                                ->uploadButtonPosition('left')
                                ->uploadProgressIndicatorPosition('left')
                                ->columnSpan(2),
                                
                            Forms\Components\FileUpload::make('gallery')
                                ->label('Galeri Produk')
                                ->multiple()
                                ->image()
                                ->disk('public')
                                ->visibility('public')
                                ->directory('products/gallery')
                                ->maxSize(2048)
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                ->helperText('Upload gambar galeri produk (Max 2MB masing-masing, JPEG, PNG, WEBP atau GIF)')
                                ->imagePreviewHeight('150')
                                ->loadingIndicatorPosition('left')
                                ->removeUploadedFileButtonPosition('right')
                                ->uploadButtonPosition('left')
                                ->uploadProgressIndicatorPosition('left')
                                ->columnSpan(2),
                        ])->columns(2),
                        
                    Step::make('Konten')
                        ->icon('heroicon-o-document-text')
                        ->description('Deskripsi dan detail produk')
                        ->schema([
                            Forms\Components\RichEditor::make('description')
                                ->required()
                                ->label('Deskripsi Produk')
                                ->toolbarButtons([
                                    'blockquote',
                                    'bold',
                                    'bulletList',
                                    'h2',
                                    'h3',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'redo',
                                    'strike',
                                    'underline',
                                    'undo',
                                ])
                                ->helperText('Jelaskan secara detail tentang produk Anda')
                                ->columnSpanFull(),
                                
                            Forms\Components\RichEditor::make('features')
                                ->label('Fitur Produk')
                                ->toolbarButtons([
                                    'blockquote',
                                    'bold',
                                    'bulletList',
                                    'h2',
                                    'h3',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'redo',
                                    'strike',
                                    'underline',
                                    'undo',
                                ])
                                ->helperText('Buat daftar fitur utama produk Anda (gunakan bullet points)')
                                ->columnSpanFull(),
                                
                            Forms\Components\RichEditor::make('requirements')
                                ->label('Persyaratan Sistem')
                                ->toolbarButtons([
                                    'blockquote',
                                    'bold',
                                    'bulletList',
                                    'h2',
                                    'h3',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'redo',
                                    'strike',
                                    'underline',
                                    'undo',
                                ])
                                ->helperText('Jelaskan persyaratan sistem atau spesifikasi yang dibutuhkan')
                                ->columnSpanFull(),
                        ]),
                        
                    Step::make('Download Link')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->description('Link download dan demo')
                        ->schema([
                            Forms\Components\TextInput::make('download_url')
                                ->label('URL Download')
                                ->url()
                                ->helperText('Masukkan URL tempat pengguna dapat mengunduh produk ini')
                                ->placeholder('https://example.com/downloads/product-file.zip'),
                                
                            Forms\Components\TextInput::make('demo_url')
                                ->label('URL Demo')
                                ->url()
                                ->helperText('Masukkan URL tempat pengguna dapat mencoba demo produk ini')
                                ->placeholder('https://demo.example.com'),
                        ]),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),
                    
                Tables\Columns\ImageColumn::make('thumbnail_url')
                    ->label('Gambar')
                    ->circular(false)
                    ->height(40)
                    ->extraAttributes(['class' => 'debug-image'])
                    ->extraImgAttributes(fn ($record) => [
                        'alt' => $record->name,
                        'onerror' => "this.onerror=null; this.src='" . asset('images/placeholder.webp') . "';"
                    ]),
                    
                Tables\Columns\TextColumn::make('category.name')
                    ->searchable()
                    ->sortable()
                    ->label('Kategori'),
                    
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable()
                    ->label('Harga'),
                    
                Tables\Columns\IconColumn::make('is_on_sale')
                    ->boolean()
                    ->label('Diskon'),
                    
                Tables\Columns\TextColumn::make('sale_price')
                    ->money('IDR')
                    ->sortable()
                    ->visible(fn ($record) => $record && $record->is_on_sale)
                    ->label('Harga Diskon'),
                    
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Aktif'),
                    
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Direkomendasikan'),
                    
                Tables\Columns\TextColumn::make('version')
                    ->toggleable()
                    ->label('Versi'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Dibuat Pada'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label('Kategori'),
                    
                Tables\Filters\Filter::make('is_active')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true))
                    ->label('Produk Aktif'),
                    
                Tables\Filters\Filter::make('is_featured')
                    ->query(fn (Builder $query): Builder => $query->where('is_featured', true))
                    ->label('Produk Direkomendasikan'),
                    
                Tables\Filters\Filter::make('is_on_sale')
                    ->query(fn (Builder $query): Builder => $query->where('is_on_sale', true))
                    ->label('Sedang Diskon'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat'),
                Tables\Actions\EditAction::make()
                    ->label('Edit'),
                Tables\Actions\Action::make('duplicate')
                    ->label('Duplikat')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('gray')
                    ->action(function (DigitalProduct $record) {
                        $newProduct = $record->replicate();
                        $newProduct->name = $record->name . ' (Copy)';
                        $newProduct->slug = $record->slug . '-copy-' . rand(100, 999);
                        $newProduct->created_at = now();
                        $newProduct->save();
                        
                        return redirect()->route('filament.admin.resources.digital-products.edit', ['record' => $newProduct->id]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activateBulk')
                        ->label('Aktifkan Semua')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_active' => true])),
                    Tables\Actions\BulkAction::make('deactivateBulk')
                        ->label('Nonaktifkan Semua')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn ($records) => $records->each->update(['is_active' => false])),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SubscriptionPlansRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDigitalProducts::route('/'),
            'create' => Pages\CreateDigitalProduct::route('/create'),
            'edit' => Pages\EditDigitalProduct::route('/{record}/edit'),
            'view' => Pages\ViewDigitalProduct::route('/{record}'),
        ];
    }
    
    public static function getNavigationGroup(): ?string
    {
        return 'Katalog';
    }
}
