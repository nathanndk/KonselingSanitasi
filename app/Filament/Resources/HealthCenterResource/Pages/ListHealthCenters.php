<?php

namespace App\Filament\Resources\HealthCenterResource\Pages;

use App\Filament\Resources\HealthCenterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHealthCenters extends ListRecords
{
    protected static string $resource = HealthCenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
