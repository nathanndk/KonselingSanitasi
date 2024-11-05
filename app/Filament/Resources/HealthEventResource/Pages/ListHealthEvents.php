<?php

namespace App\Filament\Resources\HealthEventResource\Pages;

use App\Filament\Resources\HealthEventResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHealthEvents extends ListRecords
{
    protected static string $resource = HealthEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
