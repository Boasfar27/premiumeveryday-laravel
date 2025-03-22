<?php

namespace App\Filament\Admin\Resources\SettingResource\Pages;

use App\Filament\Admin\Resources\SettingResource;
use App\Models\Setting;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Placeholder;
use Filament\Actions\Action;

class SubscriptionSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = SettingResource::class;

    protected static string $view = 'filament.admin.resources.setting-resource.pages.subscription-settings';
    
    protected static ?string $title = 'Pengaturan Langganan';
    
    public ?array $subscriptionDurations = [];
    public ?array $maxUsersOptions = [];
    
    public function mount(): void
    {
        $this->loadSettings();
    }
    
    protected function loadSettings(): void
    {
        // Load subscription durations
        $durationsSetting = Setting::where('key', 'subscription_durations')->first();
        if ($durationsSetting) {
            $durations = json_decode($durationsSetting->value, true) ?? [];
            
            $this->subscriptionDurations = [];
            foreach ($durations as $key => $value) {
                $this->subscriptionDurations[] = [
                    'key' => $key,
                    'label' => $value['label'] ?? '',
                    'days' => $value['days'] ?? 0,
                    'discount' => $value['discount'] ?? 0,
                ];
            }
        }
        
        // Load max users options
        $maxUsersSetting = Setting::where('key', 'subscription_max_users')->first();
        if ($maxUsersSetting) {
            $options = json_decode($maxUsersSetting->value, true) ?? [];
            
            $this->maxUsersOptions = [];
            foreach ($options as $key => $value) {
                $this->maxUsersOptions[] = [
                    'key' => $key,
                    'label' => $value['label'] ?? '',
                    'price_multiplier' => $value['price_multiplier'] ?? 1,
                ];
            }
        }
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Pengaturan Langganan')
                    ->description('Kelola pengaturan durasi dan jumlah pengguna langganan di sini.')
                    ->schema([
                        Placeholder::make('disclaimer')
                            ->content(new HtmlString('<div class="p-4 border border-gray-300 rounded-lg bg-gray-50">
                                <p class="text-sm text-gray-700">Pengaturan ini akan digunakan dalam pembuatan paket langganan. Perubahan hanya akan berpengaruh pada pembuatan paket baru, tidak pada paket yang sudah ada.</p>
                            </div>'))
                            ->columnSpanFull(),
                    ]),
                
                Section::make('Durasi Langganan')
                    ->description('Kelola opsi durasi yang tersedia untuk langganan.')
                    ->schema([
                        Repeater::make('subscriptionDurations')
                            ->schema([
                                \Filament\Forms\Components\TextInput::make('key')
                                    ->required()
                                    ->label('Key')
                                    ->helperText('Identifier unik, contoh: monthly, yearly (gunakan huruf kecil dan underscore)')
                                    ->maxLength(50)
                                    ->columnSpan(1),
                                    
                                \Filament\Forms\Components\TextInput::make('label')
                                    ->required()
                                    ->label('Label')
                                    ->helperText('Nama yang ditampilkan, contoh: 1 Bulan, 1 Tahun')
                                    ->maxLength(50)
                                    ->columnSpan(1),
                                    
                                \Filament\Forms\Components\TextInput::make('days')
                                    ->required()
                                    ->label('Durasi (hari)')
                                    ->helperText('Jumlah hari, contoh: 30, 365. Gunakan 0 untuk lifetime.')
                                    ->numeric()
                                    ->columnSpan(1),
                                    
                                \Filament\Forms\Components\TextInput::make('discount')
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
                
                Section::make('Opsi Jumlah Pengguna')
                    ->description('Kelola opsi jumlah pengguna maksimum dan pengali harga.')
                    ->schema([
                        Repeater::make('maxUsersOptions')
                            ->schema([
                                \Filament\Forms\Components\TextInput::make('key')
                                    ->required()
                                    ->label('Jumlah Pengguna')
                                    ->helperText('Jumlah pengguna maksimum, contoh: 1, 5, 10, atau "unlimited"')
                                    ->maxLength(50)
                                    ->columnSpan(1),
                                    
                                \Filament\Forms\Components\TextInput::make('label')
                                    ->required()
                                    ->label('Label')
                                    ->helperText('Nama yang ditampilkan, contoh: Single User, 5 Users')
                                    ->maxLength(50)
                                    ->columnSpan(1),
                                    
                                \Filament\Forms\Components\TextInput::make('price_multiplier')
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
            ]);
    }
    
    public function saveSettings()
    {
        // Save subscription durations
        $durations = [];
        foreach ($this->subscriptionDurations as $duration) {
            $key = $duration['key'] ?? '';
            if (!empty($key)) {
                $durations[$key] = [
                    'label' => $duration['label'] ?? '',
                    'days' => (int) ($duration['days'] ?? 0),
                    'discount' => (int) ($duration['discount'] ?? 0),
                ];
            }
        }
        
        Setting::updateOrCreate(
            ['key' => 'subscription_durations'],
            [
                'value' => json_encode($durations),
                'label' => 'Subscription Durations',
                'group' => 'subscription',
                'type' => 'json',
                'description' => 'Available subscription durations and their discount',
                'is_public' => true,
            ]
        );
        
        // Save max users options
        $options = [];
        foreach ($this->maxUsersOptions as $option) {
            $key = $option['key'] ?? '';
            if (!empty($key)) {
                $options[$key] = [
                    'label' => $option['label'] ?? '',
                    'price_multiplier' => (float) ($option['price_multiplier'] ?? 1),
                ];
            }
        }
        
        Setting::updateOrCreate(
            ['key' => 'subscription_max_users'],
            [
                'value' => json_encode($options),
                'label' => 'Subscription Max Users',
                'group' => 'subscription',
                'type' => 'json',
                'description' => 'Available max users options and their price multipliers',
                'is_public' => true,
            ]
        );
        
        // Clear cache
        Setting::clearAllCache();
        
        Notification::make()
            ->title('Pengaturan langganan berhasil disimpan')
            ->success()
            ->send();
    }
    
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Pengaturan')
                ->submit('save'),
        ];
    }
    
    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali ke Semua Pengaturan')
                ->url(SettingResource::getUrl()),
        ];
    }
} 