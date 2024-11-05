<?php

namespace App\Filament\Resources\PatientResource\Pages;

use App\Filament\Resources\PatientResource;
use App\Models\Address;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Pasien Telah dibuat!';
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Create or find an Address record
        $address = Address::create([
            'street' => $data['address']['street'],
            'subdistrict' => $data['address']['subdistrict'],
            'district' => $data['address']['district'],
            'city' => $data['address']['city'],
            'province' => $data['address']['province'],
        ]);

        // Associate address_id and created_by
        $data['address_id'] = $address->id;
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        // Remove address nested array as it's no longer needed
        unset($data['address']);

        return $data;
    }
}
