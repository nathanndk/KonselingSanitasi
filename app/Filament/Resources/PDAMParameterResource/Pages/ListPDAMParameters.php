<?php

namespace App\Filament\Resources\PDAMParameterResource\Pages;

use App\Filament\Resources\PDAMParameterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPDAMParameters extends ListRecords
{
    protected static string $resource = PDAMParameterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
