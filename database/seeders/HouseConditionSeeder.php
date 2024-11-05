<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HouseCondition;

class HouseConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conditions = [
            ['description' => 'Kondisi ventilasi yang memadai', 'created_by' => 1],
            ['description' => 'Kondisi pencahayaan yang cukup', 'created_by' => 1],
            ['description' => 'Kondisi air bersih tersedia', 'created_by' => 1],
            ['description' => 'Kondisi sanitasi layak', 'created_by' => 1],
            ['description' => 'Kondisi lantai kedap air', 'created_by' => 1],
        ];

        foreach ($conditions as $condition) {
            HouseCondition::create($condition);
        }
    }
}
