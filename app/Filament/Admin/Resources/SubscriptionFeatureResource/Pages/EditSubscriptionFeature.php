<?php

namespace App\Filament\Admin\Resources\SubscriptionFeatureResource\Pages;

use App\Filament\Admin\Resources\SubscriptionFeatureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubscriptionFeature extends EditRecord
{
    protected static string $resource = SubscriptionFeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
