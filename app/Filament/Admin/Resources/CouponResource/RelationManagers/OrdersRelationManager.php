<?php

namespace App\Filament\Admin\Resources\CouponResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    protected static ?string $title = 'Daftar Pesanan yang Menggunakan Kupon Ini';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_number')
                    ->label('Nomor Pesanan')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('order_number')
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('Nomor Pesanan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pelanggan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_type')
                    ->label('Tipe Pesanan')
                    ->badge(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total Pembayaran')
                    ->formatStateUsing(fn (string $state): string => 'Rp ' . number_format((float) $state, 0, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Status Pembayaran')
                    ->badge()
                    ->colors([
                        'danger' => 'failed',
                        'warning' => 'pending',
                        'success' => 'paid',
                        'gray' => 'refunded',
                    ])
                    ->formatStateUsing(function ($state) {
                        $statuses = [
                            'failed' => 'Gagal',
                            'pending' => 'Menunggu',
                            'paid' => 'Dibayar',
                            'refunded' => 'Dikembalikan',
                        ];
                        return $statuses[$state] ?? $state;
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Pemesanan')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // No create action as orders should be created through the order form
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat'),
            ])
            ->bulkActions([
                // No bulk actions needed
            ]);
    }
} 