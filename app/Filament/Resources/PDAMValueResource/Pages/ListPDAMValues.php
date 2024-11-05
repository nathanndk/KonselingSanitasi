<?php

namespace App\Filament\Resources\PDAMValueResource\Pages;

use App\Filament\Resources\PDAMValueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPDAMValues extends ListRecords
{
    protected static string $resource = PDAMValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
