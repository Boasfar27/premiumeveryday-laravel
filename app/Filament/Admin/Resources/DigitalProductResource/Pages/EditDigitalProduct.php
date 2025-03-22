<?php

namespace App\Filament\Admin\Resources\DigitalProductResource\Pages;

use App\Filament\Admin\Resources\DigitalProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditDigitalProduct extends EditRecord
{
    protected static string $resource = DigitalProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('Lihat Detail'),
                
            Actions\Action::make('duplicate')
                ->label('Duplikat Produk')
                ->icon('heroicon-m-document-duplicate')
                ->color('gray')
                ->action(function () {
                    $product = $this->record;
                    $newProduct = $product->replicate();
                    $newProduct->name = $product->name . ' (Copy)';
                    $newProduct->slug = $product->slug . '-copy-' . rand(100, 999);
                    $newProduct->created_at = now();
                    $newProduct->save();
                    
                    Notification::make()
                        ->success()
                        ->title('Produk berhasil diduplikasi')
                        ->body('Produk baru telah dibuat berdasarkan produk ini.')
                        ->send();
                        
                    return redirect()->route('filament.admin.resources.digital-products.edit', ['record' => $newProduct->id]);
                }),
                
            Actions\Action::make('viewFrontend')
                ->label('Lihat di Website')
                ->icon('heroicon-m-globe-alt')
                ->color('success')
                ->url(function () {
                    return url('/products/' . $this->record->slug);
                })
                ->openUrlInNewTab(),
                
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Produk berhasil diperbarui')
            ->body('Perubahan pada produk telah disimpan.');
    }
}
