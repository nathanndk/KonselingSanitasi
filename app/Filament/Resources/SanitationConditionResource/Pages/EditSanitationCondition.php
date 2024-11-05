<?php

namespace App\Filament\Resources\SanitationConditionResource\Pages;

use App\Filament\Resources\SanitationConditionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSanitationCondition extends EditRecord
{
    protected static string $resource = SanitationConditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
