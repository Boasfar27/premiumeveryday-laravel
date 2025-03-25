<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Filament\Admin\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    
    protected static ?string $navigationLabel = 'Pesanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pelanggan')
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->label('Nomor Pesanan')
                            ->disabled(),
                        Forms\Components\Select::make('user_id')
                            ->label('Pelanggan')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->disabled(),
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Detail Pembayaran')
                    ->schema([
                        Forms\Components\TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->prefix('Rp')
                            ->disabled(),
                        Forms\Components\TextInput::make('tax')
                            ->label('Pajak')
                            ->prefix('Rp')
                            ->disabled(),
                        Forms\Components\TextInput::make('discount_amount')
                            ->label('Diskon')
                            ->prefix('Rp')
                            ->disabled(),
                        Forms\Components\TextInput::make('total')
                            ->label('Total')
                            ->prefix('Rp')
                            ->disabled(),
                        Forms\Components\Select::make('payment_method')
                            ->label('Metode Pembayaran')
                            ->options([
                                'midtrans' => 'Midtrans',
                                'bank_transfer' => 'Transfer Bank',
                                'manual' => 'Manual',
                            ])
                            ->required(),
                        Forms\Components\Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                'pending' => 'Menunggu Pembayaran',
                                'paid' => 'Lunas',
                                'failed' => 'Gagal',
                                'expired' => 'Kadaluarsa',
                                'refunded' => 'Dikembalikan',
                            ])
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->label('Status Pesanan')
                            ->options([
                                'pending' => 'Menunggu',
                                'rejected' => 'Ditolak',
                                'approved' => 'Disetujui',
                            ])
                            ->required(),
                        Forms\Components\DateTimePicker::make('paid_at')
                            ->label('Tanggal Pembayaran'),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Catatan')
                    ->schema([
                        Forms\Components\Textarea::make('customer_notes')
                            ->label('Catatan Pelanggan')
                            ->maxLength(500),
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Catatan Admin')
                            ->maxLength(500),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('Nomor Pesanan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Pesanan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Status Pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        'expired' => 'danger',
                        'refunded' => 'info',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'paid' => 'Lunas',
                        'pending' => 'Menunggu',
                        'failed' => 'Gagal',
                        'expired' => 'Kadaluarsa',
                        'refunded' => 'Dikembalikan',
                        default => ucfirst($state),
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status Pesanan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'approved' => 'Disetujui',
                        'pending' => 'Menunggu',
                        'rejected' => 'Ditolak',
                        default => ucfirst($state),
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'paid' => 'Lunas',
                        'pending' => 'Menunggu',
                        'failed' => 'Gagal',
                        'expired' => 'Kadaluarsa',
                        'refunded' => 'Dikembalikan',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status Pesanan')
                    ->options([
                        'approved' => 'Disetujui',
                        'pending' => 'Menunggu',
                        'rejected' => 'Ditolak',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('processPayment')
                    ->label('Proses Pembayaran')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Pembayaran')
                    ->modalDescription('Apakah Anda yakin ingin memproses pembayaran ini sebagai LUNAS?')
                    ->modalSubmitActionLabel('Ya, Proses Pembayaran')
                    ->visible(fn (Order $record) => $record->payment_status === 'pending')
                    ->action(function (Order $record) {
                        // Proses pembayaran
                        $record->update([
                            'payment_status' => 'paid',
                            'status' => 'approved',
                            'paid_at' => now(),
                        ]);
                        
                        // Log aktivitas
                        \Illuminate\Support\Facades\Log::info('Admin processed payment', [
                            'order_id' => $record->id,
                            'order_number' => $record->order_number,
                            'user_id' => auth()->id(),
                        ]);
                        
                        // Notifikasi ke user
                        $notificationService = app(\App\Services\NotificationService::class);
                        $notificationService->notifyUserAboutPaymentConfirmation($record);
                        
                        // Tampilkan notifikasi sukses
                        \Filament\Notifications\Notification::make()
                            ->title('Pembayaran Berhasil Diproses')
                            ->success()
                            ->send();
                    }),
                    
                Tables\Actions\Action::make('sendOrder')
                    ->icon('heroicon-o-truck')
                    ->label('Kirim Produk')
                    ->color('primary')
                    ->form([
                        Forms\Components\Section::make('Informasi Produk dan Akun')
                            ->description('Masukkan informasi akun untuk setiap produk yang dibeli oleh pelanggan')
                            ->schema([
                                Forms\Components\Repeater::make('product_credentials')
                                    ->label('Kredensial Akun Per Produk')
                                    ->schema([
                                        Forms\Components\Select::make('order_item_id')
                                            ->label('Produk')
                                            ->options(function (callable $get, ?Order $record) {
                                                if (!$record) return [];
                                                return $record->items->pluck('name', 'id')->toArray();
                                            })
                                            ->required(),
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('username')
                                                    ->label('Username/Email')
                                                    ->required()
                                                    ->placeholder('Masukkan username/email akun'),
                                                Forms\Components\TextInput::make('password')
                                                    ->label('Password')
                                                    ->required()
                                                    ->placeholder('Masukkan password akun'),
                                            ]),
                                        Forms\Components\Grid::make(3)
                                            ->schema([
                                                Forms\Components\Select::make('subscription_type')
                                                    ->label('Tipe Langganan')
                                                    ->options([
                                                        'private' => 'Private',
                                                        'sharing' => 'Sharing',
                                                    ])
                                                    ->default('private')
                                                    ->required(),
                                                Forms\Components\TextInput::make('duration')
                                                    ->label('Durasi (bulan)')
                                                    ->numeric()
                                                    ->default(1)
                                                    ->required(),
                                                Forms\Components\DatePicker::make('expired_at')
                                                    ->label('Tanggal Kadaluarsa')
                                                    ->default(now()->addMonth())
                                                    ->required(),
                                            ]),
                                        Forms\Components\Textarea::make('instructions')
                                            ->label('Instruksi Penggunaan')
                                            ->placeholder('Masukkan petunjuk penggunaan akun (opsional)')
                                            ->rows(2),
                                    ])
                                    ->itemLabel(fn (array $state): ?string => 
                                        $state['username'] ?? 'Kredensial Baru')
                                    ->defaultItems(fn (?Order $record) => $record ? $record->items->count() : 1)
                                    ->required()
                                    ->minItems(1),
                            ]),
                    ])
                    ->modalHeading('Kirim Produk dan Informasi Akun')
                    ->modalDescription('Masukkan informasi akun premium untuk setiap produk. Pastikan data yang dimasukkan sudah benar.')
                    ->modalSubmitActionLabel('Kirim Produk dan Akun')
                    ->visible(fn (Order $record) => $record->payment_status === 'paid' && $record->status === 'approved')
                    ->action(function (Order $record, array $data) {
                        // Perbarui status pesanan
                        $record->update([
                            'status' => 'approved', // Tetap menggunakan nilai yang valid dalam database
                            'admin_notes' => ($record->admin_notes ? $record->admin_notes . "\n\n" : '') . 
                                            'Produk telah dikirim pada: ' . now()->format('d M Y H:i') . 
                                            ' oleh: ' . auth()->user()->name
                        ]);
                        
                        // Log aktivitas
                        \Illuminate\Support\Facades\Log::info('Admin sent products and credentials', [
                            'order_id' => $record->id,
                            'order_number' => $record->order_number,
                            'user_id' => auth()->id(),
                            'products_count' => count($data['product_credentials']),
                        ]);
                        
                        // Siapkan array untuk menyimpan semua credentials
                        $allCredentials = [];
                        
                        // Loop setiap credential yang diinput
                        foreach ($data['product_credentials'] as $credential) {
                            $orderItem = \App\Models\OrderItem::find($credential['order_item_id']);
                            
                            if ($orderItem) {
                                // Tambahkan informasi produk ke dalam credential
                                $credential['product_name'] = $orderItem->name;
                                $credential['product_id'] = $orderItem->product_id ?? 'P-' . str_pad($orderItem->id, 5, '0', STR_PAD_LEFT);
                                
                                // Tambahkan ke array credentials
                                $allCredentials[] = $credential;
                                
                                // Update admin notes dengan info credential untuk setiap produk
                                $record->update([
                                    'admin_notes' => $record->admin_notes . "\n" .
                                        'Info akun untuk produk "' . $orderItem->name . '": ' . 
                                        $credential['username'] . ' / [PASSWORD]'
                                ]);
                            }
                        }
                        
                        // Kirim notifikasi credentials ke user dengan semua credentials
                        $notificationService = app(\App\Services\NotificationService::class);
                        $notificationService->sendAccountCredentials($record, $allCredentials);
                        
                        // Tampilkan notifikasi sukses
                        \Filament\Notifications\Notification::make()
                            ->title('Produk dan Informasi Akun Berhasil Dikirim')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('processPaymentsBulk')
                        ->label('Proses Pembayaran (Massal)')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Konfirmasi Pembayaran Massal')
                        ->modalDescription('Apakah Anda yakin ingin memproses semua pembayaran yang dipilih sebagai LUNAS?')
                        ->modalSubmitActionLabel('Ya, Proses Pembayaran')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $processed = 0;
                            $records->each(function (Order $record) use (&$processed) {
                                if ($record->payment_status === 'pending') {
                                    $record->update([
                                        'payment_status' => 'paid',
                                        'status' => 'approved',
                                        'paid_at' => now(),
                                    ]);
                                    
                                    // Notifikasi ke user
                                    $notificationService = app(\App\Services\NotificationService::class);
                                    $notificationService->notifyUserAboutPaymentConfirmation($record);
                                    
                                    $processed++;
                                }
                            });
                            
                            // Tampilkan notifikasi sukses
                            \Filament\Notifications\Notification::make()
                                ->title($processed . ' Pembayaran Berhasil Diproses')
                                ->success()
                                ->send();
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Penjualan';
    }
}
