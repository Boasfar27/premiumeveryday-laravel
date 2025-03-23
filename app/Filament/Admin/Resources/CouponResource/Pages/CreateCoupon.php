<?php

namespace App\Filament\Admin\Resources\CouponResource\Pages;

use App\Filament\Admin\Resources\CouponResource;
use App\Services\NotificationService;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCoupon extends CreateRecord
{
    protected static string $resource = CouponResource::class;
    
    protected function afterCreate(): void
    {
        // Kirim notifikasi ke admin dan user tentang kupon baru
        $notificationService = app(NotificationService::class);
        $notificationService->notifyAdminAboutNewCoupon($this->record);
        
        // Hanya kirim ke user jika kupon aktif
        if ($this->record->is_active) {
            $notificationService->notifyUsersAboutNewCoupon($this->record);
        }
    }
}
