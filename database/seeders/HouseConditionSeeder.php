<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HouseCondition;
use App\Models\User;

class HouseConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if user with ID 1 exists, otherwise use the first user available
        $userId = User::find(1) ? 1 : User::first()->id;

        // Updated conditions data
        $conditions = [
            ['description' => 'DATA UMUM', 'created_by' => $userId],
            ['description' => 'RUMAH LAYAK', 'created_by' => $userId],
            ['description' => 'SARANA SANITASI', 'created_by' => $userId],
            ['description' => 'PERILAKU', 'created_by' => $userId],
            ['description' => 'HASIL SANITARIAN KIT', 'created_by' => $userId],
            ['description' => 'SKOR', 'created_by' => $userId],
            ['description' => 'NILAI', 'created_by' => $userId],
            ['description' => 'HASIL IKL', 'created_by' => $userId],
            ['description' => 'RUMAH (MS/TMS)', 'created_by' => $userId],
            ['description' => 'Nilai Rumah Layak', 'created_by' => $userId],
            ['description' => 'Rumah Layak (MS/TMS)', 'created_by' => $userId],
            ['description' => 'Nilai Sanitasi', 'created_by' => $userId],
            ['description' => 'Sanitasi (MS/TMS)', 'created_by' => $userId],
            ['description' => 'Nilai Perilaku', 'created_by' => $userId],
            ['description' => 'Perilaku (MS/TMS)', 'created_by' => $userId],
        ];

        foreach ($conditions as $condition) {
            HouseCondition::create($condition);
        }
    }
}
