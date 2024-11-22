<?php

namespace App\Filament\Resources\HealthEventResource\Pages;

use App\Filament\Resources\HealthEventResource;
use App\Filament\Resources\HealthEventResource\RelationManagers\CounselingReportsRelationManager;
use App\Filament\Resources\HealthEventResource\RelationManagers\HousingSurveyRelationManager;
use App\Filament\Resources\HealthEventResource\RelationManagers\PdamRelationManager;
use App\Filament\Resources\HealthEventResource\Widgets\HealthEventStatsOverview;
use App\Filament\Widgets\PuskesmasStatsOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListHealthEvents extends ListRecords
{
    protected static string $resource = HealthEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Jadwal Acara')
                ->modalHeading('Buat Jadwal Acara')
                ->modalButton('Buat Jadwal')
                ->mutateFormDataUsing(function (array $data): array {
                    if (Auth::user()->role === 'puskesmas') {
                        $data['health_center_id'] = Auth::user()->health_center_id;
                    }


                    $data['created_by'] = Auth::id();
                    $data['updated_by'] = Auth::id();
                    return $data;
                }),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            HealthEventStatsOverview::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            //         PuskesmasStatsOverview::make(),
        ];
    }
}
