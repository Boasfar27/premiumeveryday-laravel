<?php

namespace App\Filament\Admin\Resources\OrderResource\Pages;

use App\Filament\Admin\Resources\OrderResource;
use App\Services\NotificationService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Action;
use Filament\Notifications\Notification;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
            Actions\Action::make('update_status')
                ->label('Update Status')
                ->icon('heroicon-o-arrow-path')
                ->color('success')
                ->form([
                    Select::make('status')
                        ->options([
                            'rejected' => 'Rejected',
                            'approved' => 'Approved',
                        ])
                        ->required(),
                ])
                ->action(function (array $data, OrderResource\RelationManagers\ItemsRelationManager $itemsRelationManager) {
                    $notificationService = app(\App\Services\NotificationService::class);
                    $notificationService->updateOrderStatus($this->record, $data['status']);
                    
                    Notification::make()
                        ->title('Order status updated')
                        ->success()
                        ->send();
                        
                    // Jika status delivered, tambahkan form untuk informasi akun
                    if ($data['status'] === 'approved') {
                        $this->openDeliveryInformationForm();
                    }
                }),
                
            Actions\Action::make('send_account')
                ->label('Kirim Info Akun')
                ->icon('heroicon-o-envelope')
                ->color('warning')
                ->visible(fn () => $this->record->status === 'approved')
                ->action(fn () => $this->openDeliveryInformationForm()),
        ];
    }
    
    protected function openDeliveryInformationForm()
    {
        // Fetch the order items to get information
        $order = $this->record;
        $items = $order->items;
        
        // Show a modal to input account details
        $this->mountAction('deliveryInformationAction');
        $this->mountedAction->form->fill();
    }
    
    protected function getActions(): array
    {
        return [
            Actions\Action::make('deliveryInformationAction')
                ->label('Kirim Informasi Akun')
                ->icon('heroicon-o-envelope')
                ->modalHeading('Informasi Akun untuk Pelanggan')
                ->modalDescription('Masukkan detail akun yang akan dikirimkan kepada pelanggan.')
                ->modalSubmitActionLabel('Kirim')
                ->form([
                    TextInput::make('username')
                        ->label('Username/Email Akun')
                        ->required()
                        ->placeholder('contoh: premium_account123'),
                        
                    TextInput::make('password')
                        ->label('Password Akun')
                        ->required()
                        ->placeholder('password123'),
                        
                    DatePicker::make('expired_at')
                        ->label('Tanggal Kedaluwarsa')
                        ->required()
                        ->default(now()->addMonths($this->record->items->first()?->duration ?? 1)),
                        
                    Textarea::make('instructions')
                        ->label('Instruksi Penggunaan')
                        ->placeholder('Masukkan instruksi cara penggunaan akun')
                        ->rows(3),
                ])
                ->action(function (array $data) {
                    // Create account credentials array
                    $accountCredentials = [
                        'username' => $data['username'],
                        'password' => $data['password'],
                        'type' => $this->record->items->first()?->subscription_type ?? 'monthly',
                        'duration' => $this->record->items->first()?->duration ?? 1,
                        'expired_at' => \Carbon\Carbon::parse($data['expired_at'])->format('d M Y'),
                        'instructions' => $data['instructions'] ?? 'Silakan gunakan username dan password yang telah diberikan untuk login.',
                    ];
                    
                    // Use the notification service to send credentials
                    $notificationService = app(\App\Services\NotificationService::class);
                    $notificationService->sendAccountCredentials($this->record, $accountCredentials);
                    
                    // Show success notification
                    Notification::make()
                        ->title('Informasi akun berhasil dikirim')
                        ->success()
                        ->body('Informasi akun telah dikirim ke email pelanggan.')
                        ->send();
                }),
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
