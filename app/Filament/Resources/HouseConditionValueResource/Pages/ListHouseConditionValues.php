<?php

namespace App\Filament\Resources\HouseConditionValueResource\Pages;

use App\Filament\Resources\HouseConditionValueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHouseConditionValues extends ListRecords
{
    protected static string $resource = HouseConditionValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
