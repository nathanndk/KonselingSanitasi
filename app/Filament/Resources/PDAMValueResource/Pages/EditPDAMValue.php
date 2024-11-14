<?php

namespace App\Filament\Resources\PDAMValueResource\Pages;

use App\Filament\Resources\PDAMValueResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Form;

class EditPDAMValue extends EditRecord
{
    protected static string $resource = PDAMValueResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load existing parameter values into the form data
        $parameters = \App\Models\PdamParameter::all();

        foreach ($parameters as $parameter) {
            $data['parameters'][$parameter->id] = $parameter->value;
        }

        return $data;
    }

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        // Custom logic to handle updating parameter values
        DB::transaction(function () use ($data) {
            foreach ($data['parameters'] as $parameterId => $value) {
                \App\Models\PdamParameter::where('id', $parameterId)->update(['value' => $value]);
            }
        });

        return $record;
    }
}
