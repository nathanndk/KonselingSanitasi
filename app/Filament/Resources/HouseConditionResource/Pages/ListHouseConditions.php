<?php

namespace App\Filament\Resources\HouseConditionResource\Pages;

use App\Filament\Resources\HouseConditionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHouseConditions extends ListRecords
{
    protected static string $resource = HouseConditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
