<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SubscriptionPlanResource\Pages;
use App\Filament\Admin\Resources\SubscriptionPlanResource\RelationManagers;
use App\Models\DigitalProduct;
use App\Models\Setting;
use App\Models\SubscriptionPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Str;

class SubscriptionPlanResource extends Resource
{
    protected static ?string $model = SubscriptionPlan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationLabel = 'Paket Langganan';
    
    protected static ?int $navigationSort = 4;

    public static function getDurationOptions()
    {
        $rawOptions = Setting::get('subscription_durations', []);
        
        // Jika sudah berbentuk array, gunakan langsung
        if (is_array($rawOptions)) {
            return $rawOptions;
        }
        
        // Jika masih string JSON, decode terlebih dahulu
        return is_string($rawOptions) ? json_decode($rawOptions, true) : [];
    }
    
    public static function getMaxUsersOptions()
    {
        $rawOptions = Setting::get('subscription_max_users', []);
        
        // Jika sudah berbentuk array, gunakan langsung
        if (is_array($rawOptions)) {
            return $rawOptions;
        }
        
        // Jika masih string JSON, decode terlebih dahulu
        return is_string($rawOptions) ? json_decode($rawOptions, true) : [];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'default' => 1,
                    'lg' => 3,
                ])->schema([
                    Wizard::make([
                        Step::make('Informasi Dasar')
                            ->icon('heroicon-o-information-circle')
                            ->description('Atur informasi dasar paket')
                            ->schema([
                                Forms\Components\Select::make('digital_product_id')
                                    ->label('Produk Digital')
                                    ->relationship('digitalProduct', 'name')
                                    ->required()
                                    ->preload()
                                    ->reactive()
                                    ->searchable()
                                    ->afterStateUpdated(function (callable $set, callable $get, $state) {
                                        // If a product was selected, get its details
                                        if (!empty($state)) {
                                            $product = DigitalProduct::find($state);
                                            if ($product) {
                                                $set('name', $product->name . ' Subscription');
                                                $set('slug', Str::slug($product->name) . '-subscription');
                                                
                                                // Set the price based on the product price
                                                $basePrice = $product->is_on_sale ? $product->sale_price : $product->price;
                                                $set('price', $basePrice);
                                                
                                                // Calculate discount price based on duration and max users
                                                $duration = $get('duration');
                                                $maxUsers = $get('max_users');
                                                
                                                if ($duration && $maxUsers) {
                                                    $durationOptions = self::getDurationOptions();
                                                    $maxUsersOptions = self::getMaxUsersOptions();
                                                    
                                                    $discountPercentage = $durationOptions[$duration]['discount'] ?? 0;
                                                    $priceMultiplier = $maxUsersOptions[$maxUsers]['price_multiplier'] ?? 1;
                                                    
                                                    $finalPrice = $basePrice * $priceMultiplier;
                                                    $discountedPrice = $finalPrice * (1 - ($discountPercentage / 100));
                                                    
                                                    if ($discountPercentage > 0) {
                                                        $set('discount_price', floor($discountedPrice));
                                                    }
                                                }
                                            }
                                        }
                                    }),
                                    
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Paket')
                                    ->required()
                                    ->maxLength(255)
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                                    
                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->maxLength(255),
                                    
                                Forms\Components\Select::make('type')
                                    ->label('Jenis Paket')
                                    ->options([
                                        'individual' => 'Individual',
                                        'team' => 'Team',
                                        'enterprise' => 'Enterprise',
                                    ])
                                    ->default('individual')
                                    ->required(),
                                    
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Aktif')
                                    ->default(true)
                                    ->required(),
                                    
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Rekomendasi')
                                    ->helperText('Paket ini akan ditampilkan sebagai rekomendasi')
                                    ->default(false),
                            ])->columns(2),
                            
                        Step::make('Pricing')
                            ->icon('heroicon-o-currency-dollar')
                            ->description('Atur harga dan diskon')
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->label('Harga Normal')
                                    ->helperText('Harga dasar sebelum diskon durasi')
                                    ->required()
                                    ->numeric()
                                    ->reactive(),
                                    
                                Forms\Components\TextInput::make('discount_price')
                                    ->label('Harga Diskon')
                                    ->helperText('Harga setelah diskon durasi. Kosongkan untuk menggunakan harga normal')
                                    ->numeric()
                                    ->reactive(),
                                
                                Forms\Components\Select::make('duration')
                                    ->label('Durasi Langganan')
                                    ->options(function () {
                                        $durationOptions = self::getDurationOptions();
                                        $options = [];
                                        
                                        foreach ($durationOptions as $key => $option) {
                                            $options[$key] = $option['label'] ?? $key;
                                        }
                                        
                                        return $options;
                                    })
                                    ->reactive()
                                    ->required()
                                    ->afterStateUpdated(function (callable $set, callable $get, $state) {
                                        // Update discount price based on duration
                                        $productId = $get('digital_product_id');
                                        $maxUsers = $get('max_users');
                                        $basePrice = $get('price');
                                        
                                        if ($productId && $state && $basePrice) {
                                            $durationOptions = self::getDurationOptions();
                                            $maxUsersOptions = self::getMaxUsersOptions();
                                            
                                            $discountPercentage = $durationOptions[$state]['discount'] ?? 0;
                                            $priceMultiplier = $maxUsersOptions[$maxUsers]['price_multiplier'] ?? 1;
                                            
                                            $finalPrice = $basePrice * $priceMultiplier;
                                            $discountedPrice = $finalPrice * (1 - ($discountPercentage / 100));
                                            
                                            if ($discountPercentage > 0) {
                                                $set('discount_price', floor($discountedPrice));
                                            } else {
                                                $set('discount_price', null);
                                            }
                                        }
                                    }),
                                    
                                Forms\Components\Select::make('max_users')
                                    ->label('Maksimum Pengguna')
                                    ->options(function () {
                                        $maxUsersOptions = self::getMaxUsersOptions();
                                        $options = [];
                                        
                                        foreach ($maxUsersOptions as $key => $option) {
                                            $options[$key] = $option['label'] ?? $key;
                                        }
                                        
                                        return $options;
                                    })
                                    ->reactive()
                                    ->required()
                                    ->afterStateUpdated(function (callable $set, callable $get, $state) {
                                        // Update price based on max users
                                        $productId = $get('digital_product_id');
                                        $duration = $get('duration');
                                        $basePrice = $get('price');
                                        
                                        if ($productId && $duration && $basePrice) {
                                            $durationOptions = self::getDurationOptions();
                                            $maxUsersOptions = self::getMaxUsersOptions();
                                            
                                            $discountPercentage = $durationOptions[$duration]['discount'] ?? 0;
                                            $priceMultiplier = $maxUsersOptions[$state]['price_multiplier'] ?? 1;
                                            
                                            $finalPrice = $basePrice * $priceMultiplier;
                                            $discountedPrice = $finalPrice * (1 - ($discountPercentage / 100));
                                            
                                            if ($discountPercentage > 0) {
                                                $set('discount_price', floor($discountedPrice));
                                            } else {
                                                $set('discount_price', null);
                                            }
                                        }
                                    }),
                            ])->columns(2),
                            
                        Step::make('Deskripsi')
                            ->icon('heroicon-o-document-text')
                            ->description('Atur deskripsi paket')
                            ->schema([
                                Forms\Components\RichEditor::make('description')
                                    ->label('Deskripsi')
                                    ->disableToolbarButtons([
                                        'codeBlock',
                                    ])
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('subscription-plans')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan([
                        'default' => 1,
                        'lg' => 2,
                    ]),
                    
                    Section::make('Preview Paket')
                        ->description('Pratinjau tampilan paket')
                        ->columnSpan([
                            'default' => 1,
                            'lg' => 1,
                        ])
                        ->schema([
                            Placeholder::make('preview_placeholder')
                                ->content(function (callable $get) {
                                    $productId = $get('digital_product_id');
                                    $name = $get('name');
                                    $price = $get('price');
                                    $discountPrice = $get('discount_price');
                                    $duration = $get('duration');
                                    $maxUsers = $get('max_users');
                                    
                                    if (empty($productId) || empty($name) || empty($price)) {
                                        return new HtmlString('<div class="text-center p-4">
                                            <p class="text-sm text-gray-500">Lengkapi form untuk melihat pratinjau</p>
                                        </div>');
                                    }
                                    
                                    $product = DigitalProduct::find($productId);
                                    $thumbnail = $product ? $product->thumbnail_url : null;
                                    
                                    // Get duration label
                                    $durationOptions = self::getDurationOptions();
                                    $durationLabel = $durationOptions[$duration]['label'] ?? $duration;
                                    
                                    // Get max users label
                                    $maxUsersOptions = self::getMaxUsersOptions();
                                    $maxUsersLabel = $maxUsersOptions[$maxUsers]['label'] ?? $maxUsers . ' Users';
                                    
                                    return view('components.admin.subscription-plan-preview-card', [
                                        'name' => $name,
                                        'thumbnailUrl' => $thumbnail,
                                        'normalPrice' => $price,
                                        'salePrice' => $discountPrice ?? $price,
                                        'duration' => $durationLabel,
                                        'maxUsers' => $maxUsersLabel,
                                        'isFeatured' => $get('is_featured'),
                                    ]);
                                }),
                                
                            Placeholder::make('pricing_info')
                                ->content(function (callable $get) {
                                    $productId = $get('digital_product_id');
                                    $price = $get('price');
                                    $discountPrice = $get('discount_price');
                                    $duration = $get('duration');
                                    $maxUsers = $get('max_users');
                                    
                                    if (empty($productId) || empty($price) || empty($duration) || empty($maxUsers)) {
                                        return '';
                                    }
                                    
                                    // Get duration discount
                                    $durationOptions = self::getDurationOptions();
                                    $discountPercentage = $durationOptions[$duration]['discount'] ?? 0;
                                    
                                    // Get max users multiplier
                                    $maxUsersOptions = self::getMaxUsersOptions();
                                    $priceMultiplier = $maxUsersOptions[$maxUsers]['price_multiplier'] ?? 1;
                                    
                                    $html = '<div class="bg-gray-50 p-4 rounded-lg mt-4">';
                                    $html .= '<h3 class="text-sm font-medium text-gray-900">Perhitungan Harga:</h3>';
                                    $html .= '<div class="mt-2 space-y-1 text-xs text-gray-600">';
                                    $html .= '<div>Harga dasar: Rp ' . number_format($price, 0, ',', '.') . '</div>';
                                    
                                    if ($priceMultiplier > 1) {
                                        $html .= '<div>Pengali ' . $maxUsersOptions[$maxUsers]['label'] . ': x' . $priceMultiplier . '</div>';
                                        $html .= '<div>Harga setelah pengali: Rp ' . number_format($price * $priceMultiplier, 0, ',', '.') . '</div>';
                                    }
                                    
                                    if ($discountPercentage > 0) {
                                        $html .= '<div>Diskon ' . $durationOptions[$duration]['label'] . ': -' . $discountPercentage . '%</div>';
                                        $html .= '<div class="font-medium text-pink-600">Harga akhir: Rp ' . number_format($discountPrice, 0, ',', '.') . '</div>';
                                    } else {
                                        $html .= '<div class="font-medium text-pink-600">Harga akhir: Rp ' . number_format($price * $priceMultiplier, 0, ',', '.') . '</div>';
                                    }
                                    
                                    $html .= '</div></div>';
                                    
                                    return new HtmlString($html);
                                }),
                        ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('digitalProduct.name')
                    ->label('Produk Digital')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Paket')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'individual' => 'Individual',
                        'team' => 'Team',
                        'enterprise' => 'Enterprise',
                        default => $state,
                    })
                    ->colors([
                        'primary' => fn (string $state): bool => $state === 'individual',
                        'success' => fn (string $state): bool => $state === 'team',
                        'warning' => fn (string $state): bool => $state === 'enterprise',
                    ]),
                    
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('discount_price')
                    ->label('Harga Diskon')
                    ->money('IDR')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('duration')
                    ->label('Durasi')
                    ->badge()
                    ->formatStateUsing(function (string $state): string {
                        $durationOptions = self::getDurationOptions();
                        return $durationOptions[$state]['label'] ?? ucfirst($state);
                    }),
                    
                Tables\Columns\TextColumn::make('max_users')
                    ->label('Max Users')
                    ->formatStateUsing(function (string $state): string {
                        $maxUsersOptions = self::getMaxUsersOptions();
                        return $maxUsersOptions[$state]['label'] ?? $state . ' Users';
                    }),
                    
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                    
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('digitalProduct')
                    ->relationship('digitalProduct', 'name')
                    ->label('Produk Digital')
                    ->searchable()
                    ->preload(),
                    
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'individual' => 'Individual',
                        'team' => 'Team',
                        'enterprise' => 'Enterprise',
                    ])
                    ->label('Tipe'),
                    
                Tables\Filters\SelectFilter::make('duration')
                    ->options(function () {
                        $durationOptions = self::getDurationOptions();
                        $options = [];
                        
                        foreach ($durationOptions as $key => $option) {
                            $options[$key] = $option['label'] ?? $key;
                        }
                        
                        return $options;
                    })
                    ->label('Durasi'),
                    
                Tables\Filters\Filter::make('is_active')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true))
                    ->label('Aktif'),
                    
                Tables\Filters\Filter::make('is_featured')
                    ->query(fn (Builder $query): Builder => $query->where('is_featured', true))
                    ->label('Featured'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->url(fn (SubscriptionPlan $record) => route('subscription-plans.show', $record)),
                    
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Aktifkan')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn (Collection $records) => $records->each->update(['is_active' => true])),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Nonaktifkan')
                        ->icon('heroicon-o-x-circle')
                        ->action(fn (Collection $records) => $records->each->update(['is_active' => false])),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\FeaturesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptionPlans::route('/'),
            'create' => Pages\CreateSubscriptionPlan::route('/create'),
            'edit' => Pages\EditSubscriptionPlan::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationGroup(): ?string
    {
        return 'Subscriptions';
    }
}
