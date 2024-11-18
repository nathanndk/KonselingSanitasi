<?php

namespace App\Filament\Resources\SanitationConditionResource\Pages;

use App\Filament\Resources\SanitationConditionResource;
use App\Filament\Resources\SanitationConditionResource\Widgets\SanitationConditionOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSanitationConditions extends ListRecords
{
    protected static string $resource = SanitationConditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SanitationConditionOverview::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
