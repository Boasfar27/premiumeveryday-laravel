<?php

namespace App\Filament\Admin\Resources\DigitalProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReviewsRelationManager extends RelationManager
{
    protected static string $relationship = 'reviews';

    protected static ?string $recordTitleAttribute = 'title';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(5)
                    ->step(1),
                    
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                    
                Forms\Components\Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                    
                Forms\Components\Toggle::make('is_approved')
                    ->label('Approved')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Reviewer')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(50),
                    
                Tables\Columns\TextColumn::make('rating')
                    ->sortable(),
                    
                Tables\Columns\IconColumn::make('is_approved')
                    ->boolean()
                    ->label('Approved')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_approved')
                    ->query(fn (Builder $query): Builder => $query->where('is_approved', true))
                    ->label('Approved Reviews'),
                    
                Tables\Filters\Filter::make('not_approved')
                    ->query(fn (Builder $query): Builder => $query->where('is_approved', false))
                    ->label('Unapproved Reviews'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn ($record) => !$record->is_approved)
                    ->action(function ($record) {
                        $record->update(['is_approved' => true]);
                    }),
                    
                Tables\Actions\Action::make('unapprove')
                    ->label('Unapprove')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn ($record) => $record->is_approved)
                    ->action(function ($record) {
                        $record->update(['is_approved' => false]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('approve')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each->update(['is_approved' => true]);
                        }),
                        
                    Tables\Actions\BulkAction::make('unapprove')
                        ->label('Unapprove Selected')
                        ->icon('heroicon-o-x-mark')
                        ->color('danger')
                        ->action(function ($records) {
                            $records->each->update(['is_approved' => false]);
                        }),
                ]),
            ]);
    }
} 