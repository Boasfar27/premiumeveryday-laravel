<?php

namespace App\Filament\Admin\Resources\DigitalProductResource\Pages;

use App\Filament\Admin\Resources\DigitalProductResource;
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
}
