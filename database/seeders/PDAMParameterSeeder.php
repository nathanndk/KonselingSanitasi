<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PdamParameter;
use App\Models\PdamParameterCategory;

class PDAMParameterSeeder extends Seeder
{
    public function run(): void
    {
        // Retrieve or create categories
        $microbiologyCategory = PdamParameterCategory::firstOrCreate(['name' => 'Mikrobiologi']);
        $physicsCategory = PdamParameterCategory::firstOrCreate(['name' => 'Fisika']);
        $chemistryCategory = PdamParameterCategory::firstOrCreate(['name' => 'Kimia']);

        // Define parameters for each category with corresponding condition_id
        $parameters = [
            ['name' => 'Tingkat Risiko', 'condition_id' => 1],

            // Parameters with condition_id 2 and no category (parameter_category_id is null)
            ['name' => 'Sisa Chlor', 'condition_id' => 2],
            ['name' => 'pH', 'condition_id' => 2],
            ['name' => 'TDS', 'condition_id' => 2],
            ['name' => 'Suhu', 'condition_id' => 2],

            // Microbiology Parameters with condition_id 3
            ['parameter_category_id' => $microbiologyCategory->id, 'name' => 'Total Coliform', 'condition_id' => 3],
            ['parameter_category_id' => $microbiologyCategory->id, 'name' => 'E.Coli', 'condition_id' => 3],

            // Physics Parameters with condition_id 3
            ['parameter_category_id' => $physicsCategory->id, 'name' => 'TDS', 'condition_id' => 3],
            ['parameter_category_id' => $physicsCategory->id, 'name' => 'Kekeruhan', 'condition_id' => 3],
            ['parameter_category_id' => $physicsCategory->id, 'name' => 'Warna', 'condition_id' => 3],
            ['parameter_category_id' => $physicsCategory->id, 'name' => 'Bau', 'condition_id' => 3],
            ['parameter_category_id' => $physicsCategory->id, 'name' => 'Suhu', 'condition_id' => 3],

            // Chemistry Parameters with condition_id 3
            ['parameter_category_id' => $chemistryCategory->id, 'name' => 'Al', 'condition_id' => 3],
            ['parameter_category_id' => $chemistryCategory->id, 'name' => 'Arsen', 'condition_id' => 3],
            ['parameter_category_id' => $chemistryCategory->id, 'name' => 'Kadmium', 'condition_id' => 3],
            ['parameter_category_id' => $chemistryCategory->id, 'name' => 'Sisa Khlor', 'condition_id' => 3],
            ['parameter_category_id' => $chemistryCategory->id, 'name' => 'Crom val 6', 'condition_id' => 3],
            ['parameter_category_id' => $chemistryCategory->id, 'name' => 'Florida', 'condition_id' => 3],
            ['parameter_category_id' => $chemistryCategory->id, 'name' => 'Besi', 'condition_id' => 3],
            ['parameter_category_id' => $chemistryCategory->id, 'name' => 'Timbal', 'condition_id' => 3],
            ['parameter_category_id' => $chemistryCategory->id, 'name' => 'Mangan', 'condition_id' => 3],
            ['parameter_category_id' => $chemistryCategory->id, 'name' => 'Nitrit', 'condition_id' => 3],
            ['parameter_category_id' => $chemistryCategory->id, 'name' => 'Nitrat', 'condition_id' => 3],
            ['parameter_category_id' => $chemistryCategory->id, 'name' => 'pH', 'condition_id' => 3],

            ['name' => 'Keterangan', 'condition_id' => 4],

        ];

        foreach ($parameters as $parameter) {
            PdamParameter::updateOrCreate(
                ['name' => $parameter['name'], 'condition_id' => $parameter['condition_id']],
                $parameter
            );
        }
    }
}
