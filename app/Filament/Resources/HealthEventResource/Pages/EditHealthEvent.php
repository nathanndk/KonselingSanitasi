<?php

namespace App\Filament\Resources\HealthEventResource\Pages;

use App\Filament\Resources\HealthEventResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditHealthEvent extends EditRecord
{
    protected static string $resource = HealthEventResource::class;

    protected static ? string $title = 'Ubah Data Jadwal Acara';

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Mengisi updated_by setiap kali data disimpan dalam mode edit
        $data['updated_by'] = Auth::id();

        return $data;
    }

    // public function getRelationManagers(): array
    // {
    //     return [];
    // }
}
