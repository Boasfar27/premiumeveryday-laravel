<?php

namespace App\Filament\Admin\Resources\OrderResource\RelationManagers;

use App\Models\DigitalProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('product_name')
                    ->label('Produk')
                    ->disabled(),
                Forms\Components\TextInput::make('quantity')
                    ->label('Jumlah')
                    ->disabled(),
                Forms\Components\TextInput::make('price')
                    ->label('Harga')
                    ->disabled()
                    ->money('IDR'),
                Forms\Components\TextInput::make('total')
                    ->label('Total')
                    ->disabled()
                    ->money('IDR'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product_name')
                    ->label('Produk'),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('tax')
                    ->label('Pajak')
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Typically you wouldn't allow adding items directly
            ])
            ->actions([
                // Read-only view for order items
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // No bulk actions needed for order items
            ]);
    }
} 