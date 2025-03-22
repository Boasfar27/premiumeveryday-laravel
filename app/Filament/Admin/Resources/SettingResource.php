<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SettingResource\Pages;
use App\Filament\Admin\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Repeater;
use Filament\Navigation\MenuItem;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    
    protected static ?string $navigationLabel = 'System Settings';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Settings')
                    ->tabs([
                        Tab::make('General Information')
                            ->schema([
                                Section::make('Setting Information')
                                    ->schema([
                                        Forms\Components\TextInput::make('key')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255),
                                        
                                        Forms\Components\TextInput::make('label')
                                            ->required()
                                            ->maxLength(255),
                                            
                                        Forms\Components\Select::make('group')
                                            ->options([
                                                'general' => 'General',
                                                'payment' => 'Payment',
                                                'subscription' => 'Subscription',
                                                'email' => 'Email',
                                                'social' => 'Social Media',
                                                'theme' => 'Theme',
                                            ])
                                            ->required()
                                            ->default('general'),
                                            
                                        Forms\Components\Select::make('type')
                                            ->options([
                                                'text' => 'Text',
                                                'number' => 'Number',
                                                'boolean' => 'Boolean',
                                                'json' => 'JSON',
                                            ])
                                            ->reactive()
                                            ->required()
                                            ->default('text'),
                                        
                                        Forms\Components\Textarea::make('description')
                                            ->maxLength(65535)
                                            ->columnSpanFull(),
                                            
                                        Forms\Components\Toggle::make('is_public')
                                            ->required()
                                            ->default(true),
                                            
                                        Forms\Components\TextInput::make('sort_order')
                                            ->numeric()
                                            ->default(0),
                                    ])->columns(2),
                                    
                                Section::make('Value')
                                    ->schema([
                                        // Different input based on setting type
                                        Forms\Components\TextInput::make('text_value')
                                            ->label('Value')
                                            ->visible(fn (callable $get) => $get('type') === 'text')
                                            ->maxLength(65535),
                                            
                                        Forms\Components\TextInput::make('number_value')
                                            ->label('Value')
                                            ->visible(fn (callable $get) => $get('type') === 'number')
                                            ->numeric(),
                                            
                                        Forms\Components\Toggle::make('boolean_value')
                                            ->label('Value')
                                            ->visible(fn (callable $get) => $get('type') === 'boolean'),
                                            
                                        Forms\Components\Textarea::make('json_value')
                                            ->label('Value (JSON format)')
                                            ->visible(fn (callable $get) => $get('type') === 'json')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        
                        Tab::make('Subscriptions')
                            ->visible(fn ($record) => $record && ($record->key === 'subscription_durations' || $record->key === 'subscription_max_users'))
                            ->schema([
                                Forms\Components\Placeholder::make('json_editor_help')
                                    ->content('Gunakan editor visual di bawah ini untuk mengatur durasi langganan atau opsi jumlah pengguna.')
                                    ->columnSpanFull(),
                                    
                                // Subscription Durations Editor
                                Section::make('Subscription Durations')
                                    ->description('Atur durasi langganan yang tersedia dan diskon masing-masing.')
                                    ->visible(fn ($record) => $record && $record->key === 'subscription_durations')
                                    ->schema([
                                        Repeater::make('subscription_durations')
                                            ->schema([
                                                Forms\Components\TextInput::make('key')
                                                    ->required()
                                                    ->label('Key')
                                                    ->helperText('Identifier unik, contoh: monthly, yearly (gunakan huruf kecil dan underscore)')
                                                    ->maxLength(50)
                                                    ->columnSpan(1),
                                                    
                                                Forms\Components\TextInput::make('label')
                                                    ->required()
                                                    ->label('Label')
                                                    ->helperText('Nama yang ditampilkan, contoh: 1 Month, 1 Year')
                                                    ->maxLength(50)
                                                    ->columnSpan(1),
                                                    
                                                Forms\Components\TextInput::make('days')
                                                    ->required()
                                                    ->label('Durasi (hari)')
                                                    ->helperText('Jumlah hari, contoh: 30, 365. Gunakan 0 untuk lifetime.')
                                                    ->numeric()
                                                    ->columnSpan(1),
                                                    
                                                Forms\Components\TextInput::make('discount')
                                                    ->required()
                                                    ->label('Diskon (%)')
                                                    ->helperText('Persentase diskon, contoh: 10 untuk 10%')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->columnSpan(1),
                                            ])
                                            ->columns(2)
                                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                                            ->reorderable()
                                            ->collapsible()
                                            ->defaultItems(0),
                                    ]),
                                    
                                // Max Users Editor
                                Section::make('Max Users Options')
                                    ->description('Atur opsi jumlah pengguna maksimum dan pengali harga masing-masing.')
                                    ->visible(fn ($record) => $record && $record->key === 'subscription_max_users')
                                    ->schema([
                                        Repeater::make('max_users_options')
                                            ->schema([
                                                Forms\Components\TextInput::make('key')
                                                    ->required()
                                                    ->label('Jumlah Pengguna')
                                                    ->helperText('Jumlah pengguna maksimum, contoh: 1, 5, 10, atau "unlimited"')
                                                    ->maxLength(50)
                                                    ->columnSpan(1),
                                                    
                                                Forms\Components\TextInput::make('label')
                                                    ->required()
                                                    ->label('Label')
                                                    ->helperText('Nama yang ditampilkan, contoh: Single User, 5 Users')
                                                    ->maxLength(50)
                                                    ->columnSpan(1),
                                                    
                                                Forms\Components\TextInput::make('price_multiplier')
                                                    ->required()
                                                    ->label('Pengali Harga')
                                                    ->helperText('Pengali terhadap harga dasar, contoh: 1, 1.8, 4')
                                                    ->numeric()
                                                    ->default(1)
                                                    ->columnSpan(1),
                                            ])
                                            ->columns(2)
                                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                                            ->reorderable()
                                            ->collapsible()
                                            ->defaultItems(0),
                                    ]),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->searchable()
                    ->label('Key'),
                Tables\Columns\TextColumn::make('label')
                    ->searchable()
                    ->label('Label'),
                Tables\Columns\TextColumn::make('group')
                    ->badge()
                    ->label('Group'),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->label('Type'),
                Tables\Columns\TextColumn::make('value')
                    ->wrap()
                    ->limit(30)
                    ->label('Value'),
                Tables\Columns\IconColumn::make('is_public')
                    ->boolean()
                    ->label('Public'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Last Updated'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->options([
                        'general' => 'General',
                        'payment' => 'Payment',
                        'subscription' => 'Subscription',
                        'email' => 'Email',
                        'social' => 'Social Media',
                        'theme' => 'Theme',
                    ]),
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'text' => 'Text',
                        'number' => 'Number',
                        'boolean' => 'Boolean',
                        'json' => 'JSON',
                    ]),
                Tables\Filters\Filter::make('is_public')
                    ->query(fn (Builder $query): Builder => $query->where('is_public', true))
                    ->label('Public Settings'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
            'subscription-settings' => Pages\SubscriptionSettings::route('/subscription-settings'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Settings';
    }

    public static function getNavigationItems(): array
    {
        return [
            \Filament\Navigation\NavigationItem::make()
                ->label('All Settings')
                ->icon('heroicon-o-cog')
                ->url(static::getUrl()),
                
            \Filament\Navigation\NavigationItem::make()
                ->label('Subscription Settings')
                ->icon('heroicon-o-calendar')
                ->url(static::getUrl('subscription-settings')),
        ];
    }
    
    public static function mutateFormDataBeforeSave(array $data): array
    {
        // If this is subscription_durations and we have the visual editor data
        if (isset($data['subscription_durations']) && is_array($data['subscription_durations'])) {
            $durations = [];
            
            foreach ($data['subscription_durations'] as $duration) {
                $key = $duration['key'] ?? '';
                if (!empty($key)) {
                    $durations[$key] = [
                        'label' => $duration['label'] ?? '',
                        'days' => (int) ($duration['days'] ?? 0),
                        'discount' => (int) ($duration['discount'] ?? 0),
                    ];
                }
            }
            
            $data['value'] = json_encode($durations);
            unset($data['subscription_durations']);
        }
        
        // If this is subscription_max_users and we have the visual editor data
        if (isset($data['max_users_options']) && is_array($data['max_users_options'])) {
            $options = [];
            
            foreach ($data['max_users_options'] as $option) {
                $key = $option['key'] ?? '';
                if (!empty($key)) {
                    $options[$key] = [
                        'label' => $option['label'] ?? '',
                        'price_multiplier' => (float) ($option['price_multiplier'] ?? 1),
                    ];
                }
            }
            
            $data['value'] = json_encode($options);
            unset($data['max_users_options']);
        }
        
        // Handle regular settings
        switch ($data['type']) {
            case 'text':
                if (!isset($data['value'])) {
                    $data['value'] = $data['text_value'] ?? '';
                }
                break;
            case 'number':
                if (!isset($data['value'])) {
                    $data['value'] = $data['number_value'] ?? 0;
                }
                break;
            case 'boolean':
                if (!isset($data['value'])) {
                    $data['value'] = $data['boolean_value'] ? '1' : '0';
                }
                break;
            case 'json':
                if (!isset($data['value'])) {
                    $data['value'] = $data['json_value'] ?? '{}';
                }
                break;
        }
        
        // Remove the temporary value fields
        unset($data['text_value'], $data['number_value'], $data['boolean_value'], $data['json_value']);
        
        return $data;
    }
    
    public static function mutateFormDataBeforeFill(array $data): array
    {
        // Special handling for subscription_durations
        if ($data['key'] === 'subscription_durations' && $data['type'] === 'json') {
            $durations = json_decode($data['value'], true) ?? [];
            
            $data['subscription_durations'] = [];
            foreach ($durations as $key => $value) {
                $data['subscription_durations'][] = [
                    'key' => $key,
                    'label' => $value['label'] ?? '',
                    'days' => $value['days'] ?? 0,
                    'discount' => $value['discount'] ?? 0,
                ];
            }
        }
        
        // Special handling for subscription_max_users
        if ($data['key'] === 'subscription_max_users' && $data['type'] === 'json') {
            $options = json_decode($data['value'], true) ?? [];
            
            $data['max_users_options'] = [];
            foreach ($options as $key => $value) {
                $data['max_users_options'][] = [
                    'key' => $key,
                    'label' => $value['label'] ?? '',
                    'price_multiplier' => $value['price_multiplier'] ?? 1,
                ];
            }
        }
        
        // Regular field handling
        switch ($data['type']) {
            case 'text':
                $data['text_value'] = $data['value'];
                break;
            case 'number':
                $data['number_value'] = (float) $data['value'];
                break;
            case 'boolean':
                $data['boolean_value'] = (bool) $data['value'];
                break;
            case 'json':
                $data['json_value'] = $data['value'];
                break;
        }
        
        return $data;
    }
}
