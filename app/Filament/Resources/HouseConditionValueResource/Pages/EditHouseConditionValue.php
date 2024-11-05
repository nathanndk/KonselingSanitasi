<?php

namespace App\Filament\Resources\HouseConditionValueResource\Pages;

use App\Filament\Resources\HouseConditionValueResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHouseConditionValue extends EditRecord
{
    protected static string $resource = HouseConditionValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
