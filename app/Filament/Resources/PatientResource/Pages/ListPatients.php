<?php

namespace App\Filament\Resources\PatientResource\Pages;

use App\Filament\Resources\PatientResource;
use App\Filament\Resources\PatientResource\Widgets\PatientStatsOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPatients extends ListRecords
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
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
            // Actions\CreateAction::make(),
        ];
    }
}
