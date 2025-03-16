<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\FaqResource\Pages;
use App\Filament\Admin\Resources\FaqResource\RelationManagers;
use App\Models\Faq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category')
                    ->options(Faq::categories())
                    ->required()
                    ->default(Faq::CATEGORY_GENERAL),
                Forms\Components\TextInput::make('question')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('answer')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
                Forms\Components\TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => Faq::categories()[$state] ?? $state)
                    ->colors([
                        'primary' => fn ($state) => $state === Faq::CATEGORY_GENERAL,
                        'success' => fn ($state) => $state === Faq::CATEGORY_ACCOUNT,
                        'warning' => fn ($state) => $state === Faq::CATEGORY_SUBSCRIPTION,
                        'danger' => fn ($state) => $state === Faq::CATEGORY_PAYMENT,
                        'info' => fn ($state) => $state === Faq::CATEGORY_PRODUCT,
                        'gray' => fn ($state) => $state === Faq::CATEGORY_TECHNICAL,
                    ])
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('question')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options(Faq::categories())
                    ->label('Category'),
            ])
            ->actions([
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
            'index' => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit' => Pages\EditFaq::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Content Management';
    }
    
    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-question-mark-circle';
    }
}
