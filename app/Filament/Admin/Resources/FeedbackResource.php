<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\FeedbackResource\Pages;
use App\Filament\Admin\Resources\FeedbackResource\RelationManagers;
use App\Models\Feedback;
use App\Models\DigitalProduct;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FeedbackResource extends Resource
{
    protected static ?string $model = Feedback::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('avatar')
                    ->image()
                    ->directory('avatars'),
                Forms\Components\Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->default(5)
                    ->minValue(1)
                    ->maxValue(5),
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('feedbackable_type')
                    ->label('Feedback Type')
                    ->options([
                        DigitalProduct::class => 'Digital Product',
                        SubscriptionPlan::class => 'Subscription Plan',
                    ])
                    ->required()
                    ->reactive(),
                Forms\Components\Select::make('feedbackable_id')
                    ->label('Product')
                    ->options(function (callable $get) {
                        $type = $get('feedbackable_type');
                        
                        if (!$type) {
                            return [];
                        }
                        
                        if ($type === DigitalProduct::class) {
                            return DigitalProduct::pluck('name', 'id');
                        }
                        
                        if ($type === SubscriptionPlan::class) {
                            return SubscriptionPlan::pluck('name', 'id');
                        }
                        
                        return [];
                    })
                    ->required()
                    ->searchable()
                    ->preload(),
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('avatar'),
                Tables\Columns\TextColumn::make('rating')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(),
                Tables\Columns\TextColumn::make('feedbackable_type')
                    ->label('Type')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        DigitalProduct::class => 'Digital Product',
                        SubscriptionPlan::class => 'Subscription Plan',
                        default => class_basename($state),
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        DigitalProduct::class => 'success',
                        SubscriptionPlan::class => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('feedbackable.name')
                    ->label('Product')
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
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('feedbackable_type')
                    ->label('Type')
                    ->options([
                        DigitalProduct::class => 'Digital Product',
                        SubscriptionPlan::class => 'Subscription Plan',
                    ]),
                Tables\Filters\Filter::make('verified')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('user_id')),
                Tables\Filters\SelectFilter::make('rating')
                    ->options([
                        '5' => '5 Stars',
                        '4' => '4 Stars',
                        '3' => '3 Stars',
                        '2' => '2 Stars',
                        '1' => '1 Star',
                    ]),
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
            'index' => Pages\ListFeedback::route('/'),
            'create' => Pages\CreateFeedback::route('/create'),
            'edit' => Pages\EditFeedback::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Content Management';
    }
}
