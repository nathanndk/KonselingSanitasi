<?php

namespace App\Filament\Resources\SanitationConditionValueResource\Pages;

use App\Filament\Resources\SanitationConditionValueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSanitationConditionValues extends ListRecords
{
    protected static string $resource = SanitationConditionValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
