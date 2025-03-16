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
    
    protected static ?string $navigationLabel = 'Licenses';
    
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
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'active' => 'Active',
                        'expired' => 'Expired',
                        'revoked' => 'Revoked',
                    ]),
                Tables\Filters\Filter::make('expires_soon')
                    ->query(fn (Builder $query): Builder => $query->where('expires_at', '<=', now()->addDays(30))
                        ->where('expires_at', '>=', now()))
                    ->label('Expires Soon (30 days)'),
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
        return 'Product Management';
    }
}
