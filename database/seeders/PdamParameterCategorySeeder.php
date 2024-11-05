<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PdamParameterCategory;

class PdamParameterCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Water Quality'],
            ['name' => 'Sanitation'],
        ];

        foreach ($categories as $attributes) {
            PdamParameterCategory::firstOrCreate(['name' => $attributes['name']], $attributes);
        }
    }
}
