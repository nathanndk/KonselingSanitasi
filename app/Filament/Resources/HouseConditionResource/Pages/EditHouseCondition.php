<?php

namespace App\Filament\Resources\HouseConditionResource\Pages;

use App\Filament\Resources\HouseConditionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHouseCondition extends EditRecord
{
    protected static string $resource = HouseConditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
