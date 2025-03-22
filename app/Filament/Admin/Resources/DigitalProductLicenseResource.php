<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DigitalProductLicenseResource\Pages;
use App\Filament\Admin\Resources\DigitalProductLicenseResource\RelationManagers;
use App\Models\DigitalProductLicense;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DigitalProductLicenseResource extends Resource
{
    protected static ?string $model = DigitalProductLicense::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    
    protected static ?string $navigationLabel = 'Lisensi';
    
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('digital_product_id')
                    ->relationship('digitalProduct', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('order_id')
                    ->relationship('order', 'order_number')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('license_key')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'active' => 'Active',
                        'expired' => 'Expired',
                        'revoked' => 'Revoked',
                    ])
                    ->required(),
                Forms\Components\DateTimePicker::make('assigned_at'),
                Forms\Components\DateTimePicker::make('activated_at'),
                Forms\Components\DateTimePicker::make('expires_at'),
                Forms\Components\TextInput::make('max_activations')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('activation_count')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->dehydrated(),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('digitalProduct.name')
                    ->label('Product')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(),
                Tables\Columns\TextColumn::make('license_key')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'active',
                        'danger' => 'expired',
                        'gray' => 'revoked',
                    ]),
                Tables\Columns\TextColumn::make('activated_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expires_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_activations')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('activation_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Basic status filter
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'active' => 'Active',
                        'expired' => 'Expired',
                        'revoked' => 'Revoked',
                    ])
                    ->label('Status Lisensi'),
                
                // Filter licenses expiring soon
                Tables\Filters\Filter::make('expires_soon')
                    ->form([
                        Forms\Components\Select::make('expires_within')
                            ->options([
                                7 => '7 hari ke depan',
                                30 => '30 hari ke depan',
                                60 => '60 hari ke depan',
                                90 => '90 hari ke depan',
                            ])
                            ->default(30),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['expires_within'],
                                fn (Builder $query, $expiresWithin): Builder => $query
                                    ->where('expires_at', '<=', now()->addDays($expiresWithin))
                                    ->where('expires_at', '>=', now())
                                    ->where('status', 'active')
                            );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (! $data['expires_within']) {
                            return null;
                        }
                    
                        return 'Kedaluwarsa dalam ' . $data['expires_within'] . ' hari';
                    }),
                
                // Filter for never activated licenses
                Tables\Filters\Filter::make('never_activated')
                    ->label('Belum Diaktivasi')
                    ->query(fn (Builder $query): Builder => $query->whereNull('activated_at')),
                
                // Filter for licenses created in a date range
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Dibuat dari'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Dibuat hingga'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        
                        if ($data['created_from'] ?? null) {
                            $indicators[] = 'Dibuat dari ' . \Carbon\Carbon::parse($data['created_from'])->toFormattedDateString();
                        }
                        
                        if ($data['created_until'] ?? null) {
                            $indicators[] = 'Dibuat hingga ' . \Carbon\Carbon::parse($data['created_until'])->toFormattedDateString();
                        }
                        
                        return $indicators;
                    }),
                
                // Filter for licenses by specific product
                Tables\Filters\SelectFilter::make('digital_product_id')
                    ->relationship('digitalProduct', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Produk'),
                
                // Filter for licenses with high usage (approaching max activations)
                Tables\Filters\Filter::make('high_usage')
                    ->label('Penggunaan Tinggi')
                    ->query(function (Builder $query): Builder {
                        return $query->whereRaw('activation_count >= (max_activations * 0.8)');
                    }),
                
                // Filter for recently activated licenses
                Tables\Filters\Filter::make('recently_activated')
                    ->form([
                        Forms\Components\Select::make('activated_within')
                            ->options([
                                1 => '24 jam terakhir',
                                7 => '7 hari terakhir',
                                30 => '30 hari terakhir',
                            ])
                            ->default(7),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['activated_within'],
                                fn (Builder $query, $activatedWithin): Builder => $query
                                    ->whereNotNull('activated_at')
                                    ->where('activated_at', '>=', now()->subDays($activatedWithin))
                            );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (! $data['activated_within']) {
                            return null;
                        }
                        
                        $labels = [
                            1 => '24 jam terakhir',
                            7 => '7 hari terakhir',
                            30 => '30 hari terakhir',
                        ];
                        
                        return 'Diaktifkan dalam ' . $labels[$data['activated_within']] ?? '';
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('revoke')
                    ->action(function (DigitalProductLicense $record): void {
                        $record->update(['status' => 'revoked']);
                    })
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->visible(fn (DigitalProductLicense $record): bool => $record->status === 'active'),
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
            'index' => Pages\ListDigitalProductLicenses::route('/'),
            'create' => Pages\CreateDigitalProductLicense::route('/create'),
            'edit' => Pages\EditDigitalProductLicense::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationGroup(): ?string
    {
        return 'Lisensi & Aktivasi';
    }
}
