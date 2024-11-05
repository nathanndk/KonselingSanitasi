<?php

namespace App\Filament\Resources\PDAMValueResource\Pages;

use App\Filament\Resources\PDAMValueResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPDAMValue extends EditRecord
{
    protected static string $resource = PDAMValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
