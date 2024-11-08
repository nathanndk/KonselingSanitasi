<?php

namespace App\Filament\Resources\PDAMValueResource\Pages;

use App\Filament\Resources\PDAMValueResource;
use App\Models\PdamParameterValue;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePDAMValue extends CreateRecord
{
    protected static string $resource = PDAMValueResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Check if 'parameter_values' exists and is an array
        if (isset($data['parameter_values']) && is_array($data['parameter_values'])) {
            foreach ($data['parameter_values'] as $conditionId => $parameters) {
                foreach ($parameters as $parameterId => $valueArray) {
                    // Ensure value is an array and retrieve the actual 'value' key
                    if (is_array($valueArray) && isset($valueArray['value'])) {
                        PdamParameterValue::updateOrCreate(
                            [
                                'pdam_condition_id' => $conditionId,
                                'parameter_id' => $parameterId,
                            ],
                            [
                                'value' => $valueArray['value'] ?? 0,
                            ]
                        );
                    }
                }
            }
        }

        // Remove 'parameter_values' from $data to avoid saving it to the main record
        unset($data['parameter_values']);

        return $data;
    }

}
