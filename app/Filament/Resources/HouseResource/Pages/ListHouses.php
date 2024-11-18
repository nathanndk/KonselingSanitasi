<?php

namespace App\Filament\Resources\HouseResource\Pages;

use App\Filament\Resources\HouseResource;
use App\Filament\Resources\HouseResource\Widgets\HouseStatsOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHouses extends ListRecords
{
    protected static string $resource = HouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            HouseStatsOverview::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
