<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PdamConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample PDAM Conditions data with event_id set to null
        $conditions = [
            [
                'event_id' => null,
                'description' => 'Tingkat Resiko (R/S/T/ST)',
                'created_by' => Auth::id(), // Assume user_id 1 exists
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'event_id' => null,
                'description' => 'Hasil Pengukuran',
                'created_by' => 2, // Assume user_id 2 exists
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'event_id' => null,
                'description' => 'Hasil Pemeriksaan Lab',
                'created_by' => Auth::id(),
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'event_id' => null,
                'description' => 'Keterangan',
                'created_by' => Auth::id(),
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('pdam_conditions')->insert($conditions);
    }
}
