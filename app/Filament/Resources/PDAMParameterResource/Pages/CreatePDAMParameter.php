<?php

namespace App\Filament\Resources\PDAMParameterResource\Pages;

use App\Filament\Resources\PDAMParameterResource;
use App\Models\PDAMParameterValue;
use App\Models\PDAMCondition;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePDAMParameter extends CreateRecord
{
    protected static string $resource = PDAMParameterResource::class;

    protected function afterCreate(): void
    {
        $this->saveParameterValues($this->record);
    }

    /**
     * Save parameter values to PDAMParameterValue table.
     *
     * @param \App\Models\PDAMCondition $record
     * @return void
     */
    protected function saveParameterValues(PDAMCondition $record)
    {
        foreach ($record->parameters as $parameter) {
            PDAMParameterValue::updateOrCreate(
                [
                    'parameter_id' => $parameter->id,
                    'pdam_condition_id' => $record->id,
                ],
                [
                    'value' => $parameter->value,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ]
            );
        }
    }
}
