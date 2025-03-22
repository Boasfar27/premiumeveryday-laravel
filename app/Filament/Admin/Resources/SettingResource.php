<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SettingResource\Pages;
use App\Filament\Admin\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    
    protected static ?string $navigationLabel = 'System Settings';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Setting Information')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('label')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\Select::make('group')
                            ->options([
                                'general' => 'General',
                                'payment' => 'Payment',
                                'subscription' => 'Subscription',
                                'email' => 'Email',
                                'social' => 'Social Media',
                                'theme' => 'Theme',
                            ])
                            ->required()
                            ->default('general'),
                            
                        Forms\Components\Select::make('type')
                            ->options([
                                'text' => 'Text',
                                'number' => 'Number',
                                'boolean' => 'Boolean',
                                'json' => 'JSON',
                            ])
                            ->reactive()
                            ->required()
                            ->default('text'),
                        
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                            
                        Forms\Components\Toggle::make('is_public')
                            ->required()
                            ->default(true),
                            
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                    ])->columns(2),
                    
                Section::make('Value')
                    ->schema([
                        // Different input based on setting type
                        Forms\Components\TextInput::make('text_value')
                            ->label('Value')
                            ->visible(fn (callable $get) => $get('type') === 'text')
                            ->maxLength(65535),
                            
                        Forms\Components\TextInput::make('number_value')
                            ->label('Value')
                            ->visible(fn (callable $get) => $get('type') === 'number')
                            ->numeric(),
                            
                        Forms\Components\Toggle::make('boolean_value')
                            ->label('Value')
                            ->visible(fn (callable $get) => $get('type') === 'boolean'),
                            
                        Forms\Components\Textarea::make('json_value')
                            ->label('Value (JSON format)')
                            ->visible(fn (callable $get) => $get('type') === 'json')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->searchable(),
                Tables\Columns\TextColumn::make('label')
                    ->searchable(),
                Tables\Columns\TextColumn::make('group')
                    ->badge(),
                Tables\Columns\TextColumn::make('type')
                    ->badge(),
                Tables\Columns\TextColumn::make('value')
                    ->wrap()
                    ->limit(30),
                Tables\Columns\IconColumn::make('is_public')
                    ->boolean(),
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
                Tables\Filters\SelectFilter::make('group')
                    ->options([
                        'general' => 'General',
                        'payment' => 'Payment',
                        'subscription' => 'Subscription',
                        'email' => 'Email',
                        'social' => 'Social Media',
                        'theme' => 'Theme',
                    ]),
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'text' => 'Text',
                        'number' => 'Number',
                        'boolean' => 'Boolean',
                        'json' => 'JSON',
                    ]),
                Tables\Filters\Filter::make('is_public')
                    ->query(fn (Builder $query): Builder => $query->where('is_public', true))
                    ->label('Public Settings'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationGroup(): ?string
    {
        return 'Settings';
    }
    
    public static function mutateFormDataBeforeSave(array $data): array
    {
        switch ($data['type']) {
            case 'text':
                $data['value'] = $data['text_value'] ?? '';
                break;
            case 'number':
                $data['value'] = $data['number_value'] ?? 0;
                break;
            case 'boolean':
                $data['value'] = $data['boolean_value'] ? '1' : '0';
                break;
            case 'json':
                $data['value'] = $data['json_value'] ?? '{}';
                break;
        }
        
        // Remove the temporary value fields
        unset($data['text_value'], $data['number_value'], $data['boolean_value'], $data['json_value']);
        
        return $data;
    }
    
    public static function mutateFormDataBeforeFill(array $data): array
    {
        switch ($data['type']) {
            case 'text':
                $data['text_value'] = $data['value'];
                break;
            case 'number':
                $data['number_value'] = (float) $data['value'];
                break;
            case 'boolean':
                $data['boolean_value'] = (bool) $data['value'];
                break;
            case 'json':
                $data['json_value'] = $data['value'];
                break;
        }
        
        return $data;
    }
}
