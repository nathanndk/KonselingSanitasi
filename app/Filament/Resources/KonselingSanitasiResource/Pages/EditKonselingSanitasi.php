<?php

namespace App\Filament\Resources\KonselingSanitasiResource\Pages;

use App\Filament\Resources\KonselingSanitasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKonselingSanitasi extends EditRecord
{
    protected static string $resource = KonselingSanitasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
