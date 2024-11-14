<?php

namespace App\Filament\Resources\HouseConditionResource\Pages;

use App\Filament\Resources\HouseConditionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\HouseCondition;

class CreateHouseCondition extends CreateRecord
{
    protected static string $resource = HouseConditionResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Isi data default yang ingin ditampilkan saat form create dibuka
        $data['description'] = 'Default Deskripsi Kondisi';

        // Jika Anda ingin mengambil data dari model HouseCondition
        $existingHouseCondition = HouseCondition::latest()->first();
        if ($existingHouseCondition) {
            $data['description'] = $existingHouseCondition->description;
            // Isi field lain yang ingin Anda tampilkan
        }

        return $data;
    }
}
