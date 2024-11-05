<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SanitationCondition;
use Carbon\Carbon;

class SanitationConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sanitationConditions = [
            [
                'created_by' => 1,
                'patient_id' => 1,
                'counseling_date' => Carbon::parse('2024-10-31'),
                'condition' => 'Waste management issue',
                'recommendation' => 'Implement waste bins',
                'home_visit_date' => Carbon::parse('2024-11-02'),
                'intervention' => 'Waste bins provided',
                'notes' => 'Community cooperation needed'
            ],
            [
                'created_by' => 1,
                'patient_id' => 1,
                'counseling_date' => Carbon::parse('2024-11-01'),
                'condition' => 'Littering around homes',
                'recommendation' => 'Regular cleaning schedule',
                'home_visit_date' => Carbon::parse('2024-11-03'),
                'intervention' => 'Assigned cleaning duties',
                'notes' => 'Area improved significantly'
            ],
            [
                'created_by' => 1,
                'patient_id' => 1,
                'counseling_date' => Carbon::parse('2024-11-05'),
                'condition' => 'Limited access to toilets',
                'recommendation' => 'Build additional facilities',
                'home_visit_date' => Carbon::parse('2024-11-10'),
                'intervention' => 'Construction initiated',
                'notes' => 'Expected completion in two months'
            ],
        ];

        foreach ($sanitationConditions as $condition) {
            SanitationCondition::create($condition);
        }
    }
}
