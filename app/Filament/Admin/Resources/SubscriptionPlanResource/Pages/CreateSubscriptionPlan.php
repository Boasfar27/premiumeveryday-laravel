<?php

namespace App\Filament\Admin\Resources\SubscriptionPlanResource\Pages;

use App\Filament\Admin\Resources\SubscriptionPlanResource;
use App\Models\SubscriptionPlanFeature;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class CreateSubscriptionPlan extends CreateRecord
{
    protected static string $resource = SubscriptionPlanResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->record]);
    }
    
    protected function afterCreate(): void
    {
        // Add quick features if any were provided
        if ($this->data && isset($this->data['quick_features']) && is_array($this->data['quick_features'])) {
            foreach ($this->data['quick_features'] as $featureData) {
                if (isset($featureData['feature']) && !empty($featureData['feature'])) {
                    SubscriptionPlanFeature::create([
                        'subscription_plan_id' => $this->record->id,
                        'name' => $featureData['feature'],
                        'is_included' => $featureData['is_included'] ?? true,
                    ]);
                }
            }
        }
    }
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Remove the quick_features field from the data
        // as it's not a column in the subscription_plans table
        if (isset($data['quick_features'])) {
            unset($data['quick_features']);
        }
        
        return $data;
    }
    
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Paket langganan berhasil dibuat')
            ->body('Paket langganan telah berhasil dibuat. Anda dapat menambahkan lebih banyak fitur sekarang.')
            ->actions([
                \Filament\Notifications\Actions\Action::make('manage_features')
                    ->label('Kelola Fitur')
                    ->url($this->getResource()::getUrl('edit', ['record' => $this->record]))
                    ->button(),
            ]);
    }
}
