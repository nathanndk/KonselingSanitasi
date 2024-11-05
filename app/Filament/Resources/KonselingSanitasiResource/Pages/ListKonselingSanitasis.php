<?php

namespace App\Filament\Resources\KonselingSanitasiResource\Pages;

use App\Filament\Resources\KonselingSanitasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKonselingSanitasis extends ListRecords
{
    protected static string $resource = KonselingSanitasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
