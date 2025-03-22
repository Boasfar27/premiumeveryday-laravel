<?php

namespace App\Filament\Admin\Resources\SubscriptionPlanResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FeaturesRelationManager extends RelationManager
{
    protected static string $relationship = 'features';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Fitur'),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->label('Deskripsi')
                    ->helperText('Deskripsi lebih detail tentang fitur ini (opsional)'),
                Forms\Components\Toggle::make('is_included')
                    ->label('Termasuk dalam Paket?')
                    ->helperText('Aktifkan jika fitur ini termasuk dalam paket, atau nonaktifkan jika tidak termasuk')
                    ->default(true)
                    ->required(),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->label('Urutan Tampilan')
                    ->helperText('Fitur dengan nilai lebih rendah akan ditampilkan lebih dulu'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Fitur')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_included')
                    ->label('Termasuk')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\Filter::make('included')
                    ->query(fn (Builder $query): Builder => $query->where('is_included', true))
                    ->label('Fitur Termasuk'),
                Tables\Filters\Filter::make('excluded')
                    ->query(fn (Builder $query): Builder => $query->where('is_included', false))
                    ->label('Fitur Tidak Termasuk'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Fitur')
                    ->modalHeading('Tambah Fitur Baru'),
                Tables\Actions\Action::make('addCommonFeatures')
                    ->label('Tambah Fitur Umum')
                    ->color('gray')
                    ->icon('heroicon-o-bookmark')
                    ->action(function (?array $data, RelationManager $livewire) {
                        $commonFeatures = [
                            ['name' => 'Akses Penuh Produk', 'is_included' => true, 'sort_order' => 10],
                            ['name' => 'Updates Selama Periode', 'is_included' => true, 'sort_order' => 20],
                            ['name' => 'Dukungan Teknis', 'is_included' => true, 'sort_order' => 30],
                            ['name' => 'Akses Forum Komunitas', 'is_included' => true, 'sort_order' => 40],
                            ['name' => 'Dukungan Prioritas', 'is_included' => false, 'sort_order' => 50],
                            ['name' => 'Dukungan 24/7', 'is_included' => false, 'sort_order' => 60],
                        ];
                        
                        $existingFeatures = $livewire->getOwnerRecord()->features->pluck('name')->toArray();
                        
                        foreach ($commonFeatures as $feature) {
                            if (!in_array($feature['name'], $existingFeatures)) {
                                $livewire->getOwnerRecord()->features()->create($feature);
                            }
                        }
                        
                        return $livewire->refresh();
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit'),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus'),
                Tables\Actions\Action::make('toggleInclusion')
                    ->label(fn ($record) => $record->is_included ? 'Tandai Tidak Termasuk' : 'Tandai Termasuk')
                    ->icon(fn ($record) => $record->is_included ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn ($record) => $record->is_included ? 'danger' : 'success')
                    ->action(function ($record) {
                        $record->update(['is_included' => !$record->is_included]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('markAsIncluded')
                        ->label('Tandai Termasuk')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_included' => true])),
                    Tables\Actions\BulkAction::make('markAsExcluded')
                        ->label('Tandai Tidak Termasuk')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn ($records) => $records->each->update(['is_included' => false])),
                ]),
            ])
            ->emptyStateHeading('Belum ada fitur')
            ->emptyStateDescription('Fitur akan menampilkan detil apa yang termasuk dan tidak termasuk dalam paket langganan.')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Fitur')
                    ->icon('heroicon-o-plus'),
                Tables\Actions\Action::make('addCommonFeatures')
                    ->label('Tambah Fitur Umum')
                    ->color('gray')
                    ->icon('heroicon-o-bookmark')
                    ->action(function (?array $data, RelationManager $livewire) {
                        $commonFeatures = [
                            ['name' => 'Akses Penuh Produk', 'is_included' => true, 'sort_order' => 10],
                            ['name' => 'Updates Selama Periode', 'is_included' => true, 'sort_order' => 20],
                            ['name' => 'Dukungan Teknis', 'is_included' => true, 'sort_order' => 30],
                            ['name' => 'Akses Forum Komunitas', 'is_included' => true, 'sort_order' => 40],
                            ['name' => 'Dukungan Prioritas', 'is_included' => false, 'sort_order' => 50],
                            ['name' => 'Dukungan 24/7', 'is_included' => false, 'sort_order' => 60],
                        ];
                        
                        foreach ($commonFeatures as $feature) {
                            $livewire->getOwnerRecord()->features()->create($feature);
                        }
                        
                        return $livewire->refresh();
                    }),
            ]);
    }
} 