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
        $address = Address::firstOrCreate(
            [
                'street' => $data['address']['street'],
                'district_code' => $data['address']['district_code'],
                'subdistrict_code' => $data['address']['subdistrict_code'],
            ]
        );

        // Set the address_id in the patient data
        $data['address_id'] = $address->id;

        // Set created_by and updated_by fields
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        // Remove the nested address array as it's no longer needed
        unset($data['address']);

        return $data;
    }
}
