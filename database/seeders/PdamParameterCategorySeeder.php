<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PdamParameterCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Define PDAM Parameter Categories with condition IDs
        $categories = [
            // ['name' => 'Sisa Chlor', 'pdam_condition_id' => 2, 'updated_by' => null, 'created_at' => now(), 'updated_at' => now()],
            // ['name' => 'pH', 'pdam_condition_id' => 2, 'updated_by' => null, 'created_at' => now(), 'updated_at' => now()],
            // ['name' => 'TDS', 'pdam_condition_id' => 2, 'updated_by' => null, 'created_at' => now(), 'updated_at' => now()],
            // ['name' => 'Suhu', 'pdam_condition_id' => 2, 'updated_by' => null, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'Mikrobiologi', 'pdam_condition_id' => 3, 'updated_by' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fisika', 'pdam_condition_id' => 3, 'updated_by' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kimia', 'pdam_condition_id' => 3, 'updated_by' => null, 'created_at' => now(), 'updated_at' => now()],
        ];

        // Insert data into pdam_parameter_categories table
        DB::table('pdam_parameter_categories')->insert($categories);
    }
}
