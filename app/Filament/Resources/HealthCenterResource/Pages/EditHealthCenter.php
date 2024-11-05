<?php

namespace App\Filament\Resources\HealthCenterResource\Pages;

use App\Filament\Resources\HealthCenterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHealthCenter extends EditRecord
{
    protected static string $resource = HealthCenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
