<?php

namespace App\Filament\Admin\Resources\MidtransTransactionResource\Pages;

use App\Filament\Admin\Resources\MidtransTransactionResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListMidtransTransactions extends ListRecords
{
    protected static string $resource = MidtransTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
} 