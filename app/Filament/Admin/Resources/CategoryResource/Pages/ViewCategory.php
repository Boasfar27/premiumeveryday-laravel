<?php

namespace App\Filament\Admin\Resources\CategoryResource\Pages;

use App\Filament\Admin\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewCategory extends ViewRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Category Information')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\ImageEntry::make('image_url')
                                    ->label('Category Image')
                                    ->height(200)
                                    ->columnSpan(1),
                                    
                                Infolists\Components\Group::make()
                                    ->columnSpan(2)
                                    ->schema([
                                        Infolists\Components\TextEntry::make('name')
                                            ->label('Category Name')
                                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                                            ->weight('bold'),
                                            
                                        Infolists\Components\TextEntry::make('slug')
                                            ->label('Slug'),
                                            
                                        Infolists\Components\Grid::make(2)
                                            ->schema([
                                                Infolists\Components\IconEntry::make('is_active')
                                                    ->label('Active')
                                                    ->boolean(),
                                                    
                                                Infolists\Components\TextEntry::make('sort_order')
                                                    ->label('Sort Order'),
                                            ]),
                                            
                                        Infolists\Components\TextEntry::make('digitalProducts_count')
                                            ->label('Products in Category')
                                            ->state(fn ($record) => $record->digitalProducts->count()),
                                    ]),
                            ]),
                            
                        Infolists\Components\TextEntry::make('description')
                            ->label('Description')
                            ->html()
                            ->columnSpanFull(),
                    ]),
                    
                Infolists\Components\Section::make('Products in Category')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('digitalProducts')
                            ->schema([
                                Infolists\Components\Grid::make(3)
                                    ->schema([
                                        Infolists\Components\ImageEntry::make('thumbnail_url')
                                            ->label('Image')
                                            ->height(100)
                                            ->columnSpan(1),
                                            
                                        Infolists\Components\Group::make()
                                            ->columnSpan(2)
                                            ->schema([
                                                Infolists\Components\TextEntry::make('name')
                                                    ->label('Product Name')
                                                    ->url(fn ($record) => CategoryResource::getUrl('edit', ['record' => $record->id]))
                                                    ->weight('bold'),
                                                    
                                                Infolists\Components\TextEntry::make('price')
                                                    ->label('Price')
                                                    ->money('IDR'),
                                                    
                                                Infolists\Components\IconEntry::make('is_on_sale')
                                                    ->label('On Sale')
                                                    ->boolean(),
                                            ]),
                                    ]),
                            ])
                            ->columns(1)
                            ->visible(fn ($record) => $record->digitalProducts->count() > 0),
                            
                        Infolists\Components\TextEntry::make('no_products')
                            ->label('No Products')
                            ->state('No products in this category')
                            ->visible(fn ($record) => $record->digitalProducts->count() === 0),
                    ]),
                    
                Infolists\Components\Section::make('Dates')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Created')
                                    ->dateTime(),
                                    
                                Infolists\Components\TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime(),
                            ]),
                    ]),
            ]);
    }
} 