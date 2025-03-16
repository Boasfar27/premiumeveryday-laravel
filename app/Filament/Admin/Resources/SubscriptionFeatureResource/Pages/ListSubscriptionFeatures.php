<?php

namespace App\Filament\Admin\Resources\SubscriptionFeatureResource\Pages;

use App\Filament\Admin\Resources\SubscriptionFeatureResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubscriptionFeatures extends ListRecords
{
    protected static string $resource = SubscriptionFeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
