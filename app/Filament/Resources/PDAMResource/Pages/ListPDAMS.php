<?php

namespace App\Filament\Resources\PDAMResource\Pages;

use App\Filament\Resources\PDAMResource;
use App\Filament\Resources\PDAMResource\Widgets\PdamStatsOverview;
use App\Filament\Widgets\PuskesmasStatsOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPDAMS extends ListRecords
{
    protected static string $resource = PDAMResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PdamStatsOverview::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            // PuskesmasStatsOverview::make(),
        ];
    }
}
