<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SubscriptionFeatureResource\Pages;
use App\Filament\Admin\Resources\SubscriptionFeatureResource\RelationManagers;
use App\Models\SubscriptionFeature;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubscriptionFeatureResource extends Resource
{
    protected static ?string $model = SubscriptionFeature::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    
    protected static ?string $navigationLabel = 'Subscription Features';
    
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('subscription_plan_id')
                    ->relationship('subscriptionPlan', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_highlighted')
                    ->required(),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subscriptionPlan.name')
                    ->label('Plan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50),
                Tables\Columns\IconColumn::make('is_highlighted')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('subscription_plan')
                    ->relationship('subscriptionPlan', 'name'),
                Tables\Filters\Filter::make('is_highlighted')
                    ->query(fn (Builder $query): Builder => $query->where('is_highlighted', true))
                    ->label('Highlighted Features'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order');
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
            'index' => Pages\ListSubscriptionFeatures::route('/'),
            'create' => Pages\CreateSubscriptionFeature::route('/create'),
            'edit' => Pages\EditSubscriptionFeature::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationGroup(): ?string
    {
        return 'Product Management';
    }
}
