<?php

namespace App\Filament\Admin\Widgets;

use App\Models\DigitalProductLicense;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestLicenseActivations extends BaseWidget
{
    protected static ?int $sort = 6;
    
    protected int | string | array $columnSpan = 'full';
    
    protected function getTableHeading(): string
    {
        return 'Aktivasi Lisensi Terbaru';
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->query(
                DigitalProductLicense::query()
                    ->whereNotNull('activated_at')
                    ->with(['product', 'user'])
                    ->latest('activated_at')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('license_code')
                    ->label('Kode Lisensi')
                    ->searchable()
                    ->copyable()
                    ->tooltip('Salin kode lisensi'),
                
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produk')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pengguna')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('activated_at')
                    ->label('Diaktivasi Pada')
                    ->dateTime()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('activation_ip')
                    ->label('IP Aktivasi')
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'expired' => 'danger',
                        'revoked' => 'warning',
                        default => 'gray',
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->url(fn (DigitalProductLicense $record): string => route('filament.admin.resources.digital-product-licenses.edit', $record))
                    ->icon('heroicon-m-eye'),
            ]);
    }
} 