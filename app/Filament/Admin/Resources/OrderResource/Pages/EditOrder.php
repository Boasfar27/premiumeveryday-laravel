<?php

namespace App\Filament\Admin\Resources\OrderResource\Pages;

use App\Filament\Admin\Resources\OrderResource;
use App\Services\NotificationService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Cek apakah status pesanan berubah
        if ($this->record->isDirty('status')) {
            $oldStatus = $this->record->getOriginal('status');
            $newStatus = $this->record->status;

            // Kirim notifikasi perubahan status
            app(NotificationService::class)->notifyOrderStatusChange(
                $this->record, 
                $oldStatus, 
                $newStatus
            );
        }
    }
}
