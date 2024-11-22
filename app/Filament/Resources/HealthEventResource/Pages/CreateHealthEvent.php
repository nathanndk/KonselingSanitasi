<?php

namespace App\Filament\Resources\HealthEventResource\Pages;

use App\Filament\Resources\HealthEventResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateHealthEvent extends CreateRecord
{
    protected static string $resource = HealthEventResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        // Menambahkan health_center_id hanya jika role user adalah 'puskesmas'
        if (Auth::user()->role === 'puskesmas') {
            $data['health_center_id'] = Auth::user()->health_center_id;
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
