<?php

namespace App\Filament\Resources\HealthEventResource\Pages;

use App\Filament\Resources\HealthEventResource;
use App\Filament\Resources\HealthEventResource\RelationManagers\CounselingReportsRelationManager;
use App\Filament\Resources\HealthEventResource\RelationManagers\HousingSurveyRelationManager;
use App\Filament\Resources\HealthEventResource\RelationManagers\PdamRelationManager;
use Filament\Resources\Pages\ViewRecord;

class ViewHealthEvent extends ViewRecord
{
    protected static string $resource = HealthEventResource::class;

    public function getRelationManagers(): array
    {
        return [
            CounselingReportsRelationManager::class,
            HousingSurveyRelationManager::class,
            PdamRelationManager::class,
        ];
    }
}
