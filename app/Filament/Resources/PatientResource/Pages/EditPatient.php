<?php

namespace App\Filament\Resources\PatientResource\Pages;

use App\Filament\Resources\PatientResource;
use App\Models\Address;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditPatient extends EditRecord
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Memeriksa apakah field alamat diupdate
        if (isset($data['address']['street']) && isset($data['address']['district_code']) && isset($data['address']['subdistrict_code'])) {
            // Mencari atau membuat alamat baru di tabel address
            $address = Address::firstOrCreate([
                'street' => $data['address']['street'],
                'district_code' => $data['address']['district_code'],
                'subdistrict_code' => $data['address']['subdistrict_code'],
            ]);

            // Menyimpan address_id di data pasien
            $data['address_id'] = $address->id;
        }

        // Menyimpan updated_by dengan ID pengguna saat ini
        $data['updated_by'] = Auth::id();

        // Menghapus data alamat yang tidak diperlukan
        unset($data['address']);

        return $data;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Data Pasien telah diperbarui!';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
{
    if ($this->record->address) {
        $data['address']['street'] = $this->record->address->street;
        $data['address']['district_code'] = $this->record->address->district_code;
        $data['address']['subdistrict_code'] = $this->record->address->subdistrict_code;
    }

    return $data;
}

}
