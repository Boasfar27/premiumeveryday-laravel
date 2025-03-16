<?php

namespace App\Filament\Admin\Resources\DigitalProductLicenseResource\Pages;

use App\Filament\Admin\Resources\DigitalProductLicenseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDigitalProductLicenses extends ListRecords
{
    protected static string $resource = DigitalProductLicenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
