<?php

namespace App\Filament\Admin\Resources\MidtransTransactionResource\Pages;

use App\Filament\Admin\Resources\MidtransTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMidtransTransaction extends ViewRecord
{
    protected static string $resource = MidtransTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
} 