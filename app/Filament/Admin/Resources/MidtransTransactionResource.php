<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MidtransTransactionResource\Pages;
use App\Models\MidtransTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\KeyValue;

class MidtransTransactionResource extends Resource
{
    protected static ?string $model = MidtransTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Penjualan';

    protected static ?string $navigationLabel = 'Transaksi Midtrans';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Transaksi')
                    ->schema([
                        Grid::make()
                            ->schema([
                                Forms\Components\Select::make('order_id')
                                    ->relationship('order', 'order_number')
                                    ->required()
                                    ->searchable()
                                    ->label('Nomor Pesanan'),
                                Forms\Components\TextInput::make('transaction_id')
                                    ->maxLength(255)
                                    ->label('ID Transaksi'),
                                Forms\Components\TextInput::make('midtrans_order_id')
                                    ->maxLength(255)
                                    ->label('ID Pesanan Midtrans'),
                                Forms\Components\TextInput::make('payment_type')
                                    ->maxLength(255)
                                    ->label('Metode Pembayaran'),
                            ]),
                    ]),
                
                Section::make('Detail Pembayaran')
                    ->schema([
                        Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('gross_amount')
                                    ->numeric()
                                    ->label('Jumlah'),
                                Forms\Components\DateTimePicker::make('transaction_time')
                                    ->label('Waktu Transaksi'),
                                Forms\Components\TextInput::make('transaction_status')
                                    ->maxLength(255)
                                    ->label('Status Transaksi'),
                                Forms\Components\TextInput::make('status_code')
                                    ->maxLength(255)
                                    ->label('Kode Status'),
                            ]),
                    ]),
                
                Section::make('Detail Metode Pembayaran')
                    ->schema([
                        Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('payment_code')
                                    ->maxLength(255)
                                    ->label('Kode Pembayaran'),
                                Forms\Components\TextInput::make('pdf_url')
                                    ->maxLength(255)
                                    ->label('URL Instruksi Pembayaran'),
                                Forms\Components\DateTimePicker::make('expiry_time')
                                    ->label('Waktu Kadaluarsa'),
                                Forms\Components\KeyValue::make('payment_methods')
                                    ->label('Metode Pembayaran Tersedia')
                                    ->keyLabel('Metode')
                                    ->valueLabel('Status')
                                    ->columnSpan(2),
                            ]),
                    ]),
                
                Section::make('Token dan URL')
                    ->schema([
                        Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('snap_token')
                                    ->maxLength(255)
                                    ->label('Token Snap'),
                                Forms\Components\TextInput::make('redirect_url')
                                    ->maxLength(255)
                                    ->label('URL Redirect'),
                            ]),
                    ]),

                Section::make('Status dan Pesan')
                    ->schema([
                        Grid::make()
                            ->schema([
                                Forms\Components\Textarea::make('status_message')
                                    ->label('Pesan Status'),
                                Forms\Components\TextInput::make('fraud_status')
                                    ->maxLength(255)
                                    ->label('Status Fraud'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.order_number')
                    ->searchable()
                    ->sortable()
                    ->label('Nomor Pesanan'),
                Tables\Columns\TextColumn::make('transaction_id')
                    ->searchable()
                    ->label('ID Transaksi'),
                Tables\Columns\TextColumn::make('midtrans_order_id')
                    ->searchable()
                    ->label('ID Pesanan Midtrans'),
                Tables\Columns\TextColumn::make('payment_type')
                    ->searchable()
                    ->label('Metode Pembayaran'),
                Tables\Columns\TextColumn::make('gross_amount')
                    ->money('idr')
                    ->sortable()
                    ->label('Jumlah'),
                Tables\Columns\BadgeColumn::make('transaction_status')
                    ->colors([
                        'success' => 'settlement',
                        'warning' => 'pending',
                        'danger' => 'deny',
                        'danger' => 'cancel',
                        'danger' => 'expire',
                        'info' => 'challenge',
                    ])
                    ->searchable()
                    ->label('Status'),
                Tables\Columns\TextColumn::make('transaction_time')
                    ->dateTime()
                    ->sortable()
                    ->label('Waktu Transaksi'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable()
                    ->label('Dibuat Pada'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('transaction_status')
                    ->options([
                        'capture' => 'Capture',
                        'settlement' => 'Settlement',
                        'pending' => 'Pending',
                        'deny' => 'Deny',
                        'cancel' => 'Cancel',
                        'expire' => 'Expire',
                        'refund' => 'Refund',
                        'partial_refund' => 'Partial Refund',
                        'authorize' => 'Authorize',
                        'challenge' => 'Challenge',
                    ])
                    ->label('Status Transaksi'),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Sampai Tanggal'),
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
                    ->label('Tanggal Transaksi'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMidtransTransactions::route('/'),
            'create' => Pages\CreateMidtransTransaction::route('/create'),
            'edit' => Pages\EditMidtransTransaction::route('/{record}/edit'),
            'view' => Pages\ViewMidtransTransaction::route('/{record}'),
        ];
    }
} 