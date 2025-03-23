<?php

namespace App\Filament\Admin\Resources\DigitalProductResource\Pages;

use App\Filament\Admin\Resources\DigitalProductResource;
use App\Services\NotificationService;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateDigitalProduct extends CreateRecord
{
    protected static string $resource = DigitalProductResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->record]);
    }
    
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Produk berhasil dibuat')
            ->body('Produk digital telah berhasil dibuat. Anda dapat menambahkan subscription plan sekarang.')
            ->actions([
                \Filament\Notifications\Actions\Action::make('view')
                    ->label('Tambah Subscription Plan') 
                    ->url($this->getResource()::getUrl('edit', ['record' => $this->record]))
                    ->button(),
            ]);
    }

    protected function afterCreate(): void
    {
        // Kirim notifikasi ke user tentang produk baru
        if ($this->record->is_active) {
            app(NotificationService::class)->notifyUsersAboutNewProduct($this->record);
        }
        
        // Notifikasi ke admin lain
        app(NotificationService::class)->notifyAdminAboutNewProduct($this->record);
    }
}
