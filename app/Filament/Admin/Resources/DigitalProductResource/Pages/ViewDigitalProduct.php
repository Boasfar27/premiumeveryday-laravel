<?php

namespace App\Filament\Admin\Resources\DigitalProductResource\Pages;

use App\Filament\Admin\Resources\DigitalProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewDigitalProduct extends ViewRecord
{
    protected static string $resource = DigitalProductResource::class;

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
                Infolists\Components\Section::make('Product Overview')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\ImageEntry::make('thumbnail_url')
                                    ->label('Product Image')
                                    ->height(200)
                                    ->columnSpan(1),
                                    
                                Infolists\Components\Group::make()
                                    ->columnSpan(2)
                                    ->schema([
                                        Infolists\Components\TextEntry::make('name')
                                            ->label('Product Name')
                                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                                            ->weight('bold'),
                                            
                                        Infolists\Components\TextEntry::make('category.name')
                                            ->label('Category'),
                                            
                                        Infolists\Components\Grid::make(2)
                                            ->schema([
                                                Infolists\Components\TextEntry::make('price')
                                                    ->label('Regular Price')
                                                    ->money('IDR'),
                                                    
                                                Infolists\Components\TextEntry::make('sale_price')
                                                    ->label('Sale Price')
                                                    ->money('IDR')
                                                    ->visible(fn ($record) => $record && $record->is_on_sale),
                                            ]),
                                            
                                        Infolists\Components\Grid::make(3)
                                            ->schema([
                                                Infolists\Components\IconEntry::make('is_active')
                                                    ->label('Active')
                                                    ->boolean(),
                                                    
                                                Infolists\Components\IconEntry::make('is_featured')
                                                    ->label('Featured')
                                                    ->boolean(),
                                                    
                                                Infolists\Components\IconEntry::make('is_on_sale')
                                                    ->label('On Sale')
                                                    ->boolean(),
                                            ]),
                                            
                                        Infolists\Components\TextEntry::make('version')
                                            ->label('Version'),
                                            
                                        Infolists\Components\TextEntry::make('product_type')
                                            ->label('Product Type'),
                                    ]),
                            ]),
                    ]),
                    
                Infolists\Components\Section::make('Product Content')
                    ->schema([
                        Infolists\Components\Tabs::make('Content')
                            ->tabs([
                                Infolists\Components\Tabs\Tab::make('Description')
                                    ->schema([
                                        Infolists\Components\TextEntry::make('description')
                                            ->label('Product Description')
                                            ->html(),
                                    ]),
                                    
                                Infolists\Components\Tabs\Tab::make('Features')
                                    ->schema([
                                        Infolists\Components\TextEntry::make('features')
                                            ->label('Product Features')
                                            ->html(),
                                    ]),
                                    
                                Infolists\Components\Tabs\Tab::make('Requirements')
                                    ->schema([
                                        Infolists\Components\TextEntry::make('requirements')
                                            ->label('System Requirements')
                                            ->html(),
                                    ]),
                                    
                                Infolists\Components\Tabs\Tab::make('Gallery')
                                    ->schema([
                                        Infolists\Components\RepeatableEntry::make('gallery')
                                            ->schema([
                                                Infolists\Components\ImageEntry::make('')
                                                    ->disk('public'),
                                            ]),
                                    ]),
                            ]),
                    ]),
                    
                Infolists\Components\Section::make('Download Information')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('download_url')
                                    ->label('Download URL')
                                    ->url(fn ($record) => $record && $record->download_url ? $record->download_url : null)
                                    ->openUrlInNewTab(),
                                    
                                Infolists\Components\TextEntry::make('demo_url')
                                    ->label('Demo URL')
                                    ->url(fn ($record) => $record && $record->demo_url ? $record->demo_url : null)
                                    ->openUrlInNewTab(),
                            ]),
                    ]),
                    
                Infolists\Components\Section::make('Metrics')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('download_count')
                                    ->label('Downloads'),
                                    
                                Infolists\Components\TextEntry::make('reviews_count')
                                    ->label('Reviews')
                                    ->state(fn ($record) => $record && $record->reviews ? $record->reviews->count() : 0),
                                    
                                Infolists\Components\TextEntry::make('average_rating')
                                    ->label('Average Rating')
                                    ->state(fn ($record) => $record && $record->reviews && $record->reviews->count() > 0 ? $record->reviews->avg('rating') : 'No Ratings'),
                            ]),
                    ]),
                    
                Infolists\Components\Section::make('Dates')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Created')
                                    ->dateTime(),
                                    
                                Infolists\Components\TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime(),
                                    
                                Infolists\Components\TextEntry::make('sale_ends_at')
                                    ->label('Sale Ends')
                                    ->dateTime()
                                    ->visible(fn ($record) => $record && $record->is_on_sale && $record->sale_ends_at),
                            ]),
                    ]),
            ]);
    }
} 