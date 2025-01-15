<?php

namespace App\Filament\Resources\PatientResource\Pages;

use App\Filament\Resources\PatientResource;
use App\Filament\Resources\PatientResource\Widgets\PatientStatsOverview;
use App\Models\Address;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListPatients extends ListRecords
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    // Check if the address already exists or create a new one
                    $address = Address::firstOrCreate([
                        'street' => $data['address']['street'] ?? null,
                        'district_code' => $data['address']['district_code'] ?? null,
                        'subdistrict_code' => $data['address']['subdistrict_code'] ?? null,
                        'rt' => $data['address']['rt'] ?? null,
                        'rw' => $data['address']['rw'] ?? null,
                    ]);

                    // Set the address_id in the data array
                    $data['address_id'] = $address->id;

                    // Set default values for created_by and updated_by
                    $data['created_by'] = Auth::id();
                    $data['updated_by'] = Auth::id();

                    return $data;
                })
                ->modalHeading('Buat Formulir Pasien')
            ,
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PatientStatsOverview::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            // Add footer widgets if needed
        ];
    }
}
