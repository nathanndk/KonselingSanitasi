<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PDAMParameter;
use App\Models\PdamParameterCategory;

class PDAMParameterSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch IDs by category name
        $waterQualityCategory = PdamParameterCategory::where('name', 'Water Quality')->first();
        $sanitationCategory = PdamParameterCategory::where('name', 'Sanitation')->first();

        $parameters = [
            ['parameter_category_id' => $waterQualityCategory->id, 'name' => 'pH Level'],
            ['parameter_category_id' => $waterQualityCategory->id, 'name' => 'Turbidity'],
            ['parameter_category_id' => $sanitationCategory->id, 'name' => 'Chlorine Residual'],
        ];

        foreach ($parameters as $parameter) {
            PDAMParameter::create($parameter);
        }
    }
}
