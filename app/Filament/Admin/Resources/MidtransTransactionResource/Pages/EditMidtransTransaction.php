<?php

namespace App\Filament\Admin\Resources\MidtransTransactionResource\Pages;

use App\Filament\Admin\Resources\MidtransTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMidtransTransaction extends EditRecord
{
    protected static string $resource = MidtransTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
} 