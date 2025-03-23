<?php

namespace App\Filament\Admin\Resources\CouponResource\Pages;

use App\Filament\Admin\Resources\CouponResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCoupon extends EditRecord
{
    protected static string $resource = CouponResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Hapus')
                ->modalHeading('Hapus Kupon')
                ->modalDescription('Apakah Anda yakin ingin menghapus kupon ini? Tindakan ini tidak dapat dibatalkan.')
                ->modalSubmitActionLabel('Ya, Hapus')
                ->modalCancelActionLabel('Batal'),
        ];
    }
    
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Kupon berhasil diperbarui';
    }
}
