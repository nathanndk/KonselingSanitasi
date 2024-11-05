<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HouseParameterValue;

class HouseParameterValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            ['parameter_id' => 1, 'house_condition_id' => 1, 'value' => 1.0, 'created_by' => 1],
            ['parameter_id' => 2, 'house_condition_id' => 2, 'value' => 0.9, 'created_by' => 1],
            ['parameter_id' => 3, 'house_condition_id' => 3, 'value' => 0.8, 'created_by' => 1],
            ['parameter_id' => 4, 'house_condition_id' => 4, 'value' => 0.7, 'created_by' => 1],
            ['parameter_id' => 5, 'house_condition_id' => 5, 'value' => 1.0, 'created_by' => 1],
            ['parameter_id' => 6, 'house_condition_id' => 1, 'value' => 0.95, 'created_by' => 1],
        ];

        foreach ($values as $value) {
            HouseParameterValue::create($value);
        }
    }
}
