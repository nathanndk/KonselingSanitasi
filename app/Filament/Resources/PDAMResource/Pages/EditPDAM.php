<?php

namespace App\Filament\Resources\PDAMResource\Pages;

use App\Filament\Resources\PDAMResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPDAM extends EditRecord
{
    protected static string $resource = PDAMResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
