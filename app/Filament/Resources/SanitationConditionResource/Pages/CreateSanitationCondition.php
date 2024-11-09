<?php

namespace App\Filament\Resources\SanitationConditionResource\Pages;

use App\Filament\Resources\SanitationConditionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateSanitationCondition extends CreateRecord
{
    protected static string $resource = SanitationConditionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Laporan Konseling Sanitasi Telah dibuat!';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        // Set event_id to null if not provided
        if (!isset($data['event_id'])) {
            $data['event_id'] = null;
        }

        return $data;
    }
}
