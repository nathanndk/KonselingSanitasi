<?php

namespace App\Filament\Resources\HealthCenterResource\Pages;

use App\Filament\Resources\HealthCenterResource;
use App\Models\Address;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateHealthCenter extends CreateRecord
{
    protected static string $resource = HealthCenterResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Puskesmas Telah dibuat!';
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
