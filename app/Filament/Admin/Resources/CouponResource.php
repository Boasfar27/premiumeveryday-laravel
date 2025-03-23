<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CouponResource\Pages;
use App\Filament\Admin\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use App\Services\NotificationService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label('Kode Kupon')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('discount')
                    ->label('Nilai Diskon')
                    ->required()
                    ->numeric()
                    ->step(0.01),
                Forms\Components\Select::make('type')
                    ->label('Jenis Diskon')
                    ->options([
                        'percentage' => 'Persentase (%)',
                        'fixed' => 'Nilai Tetap (Rp)',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('min_purchase')
                    ->label('Minimum Pembelian (Rp)')
                    ->numeric()
                    ->default(0)
                    ->step(0.01)
                    ->required(),
                Forms\Components\TextInput::make('max_discount')
                    ->label('Maksimum Diskon (Rp)')
                    ->numeric()
                    ->default(0)
                    ->step(0.01)
                    ->required(),
                Forms\Components\TextInput::make('max_uses')
                    ->label('Maksimum Penggunaan')
                    ->numeric()
                    ->minValue(1)
                    ->placeholder('Tidak Terbatas'),
                Forms\Components\TextInput::make('used_count')
                    ->label('Jumlah Penggunaan')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->dehydrated(),
                Forms\Components\DateTimePicker::make('expires_at')
                    ->label('Tanggal Kadaluarsa')
                    ->placeholder('Tidak Pernah Kadaluarsa'),
                Forms\Components\DateTimePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->default(now())
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->required()
                    ->default(true),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode Kupon')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('discount')
                    ->label('Nilai Diskon')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->type === 'percentage') {
                            return $state . '%';
                        }
                        return 'Rp ' . number_format($state, 0, ',', '.');
                    }),
                Tables\Columns\BadgeColumn::make('type')
                    ->label('Jenis')
                    ->colors([
                        'primary' => 'percentage',
                        'success' => 'fixed',
                    ])
                    ->formatStateUsing(function ($state) {
                        return $state === 'percentage' ? 'Persentase' : 'Nilai Tetap';
                    }),
                Tables\Columns\TextColumn::make('max_uses')
                    ->label('Maksimum Penggunaan')
                    ->numeric()
                    ->sortable()
                    ->placeholder('Tidak Terbatas'),
                Tables\Columns\TextColumn::make('used_count')
                    ->label('Jumlah Penggunaan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Tanggal Kadaluarsa')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('Tidak Pernah Kadaluarsa'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Jenis')
                    ->options([
                        'percentage' => 'Persentase',
                        'fixed' => 'Nilai Tetap',
                    ]),
                Tables\Filters\Filter::make('is_active')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true))
                    ->label('Kupon Aktif'),
                Tables\Filters\Filter::make('is_valid')
                    ->query(function (Builder $query): Builder {
                        return $query->where('is_active', true)
                            ->where(function ($query) {
                                $query->whereNull('expires_at')
                                    ->orWhere('expires_at', '>', now());
                            })
                            ->where(function ($query) {
                                $query->whereNull('max_uses')
                                    ->orWhereRaw('used_count < max_uses');
                            });
                    })
                    ->label('Kupon Berlaku'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OrdersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Penjualan';
    }
}
