<?php

namespace App\Filament\Admin\Resources\DigitalProductLicenseResource\Pages;

use App\Filament\Admin\Resources\DigitalProductLicenseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDigitalProductLicense extends EditRecord
{
    protected static string $resource = DigitalProductLicenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
