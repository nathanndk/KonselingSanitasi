<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HouseParameter;

class HouseParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parameters = [
            ['parameter_category_id' => 1, 'name' => 'Atap Kuat dan Tidak Bocor', 'created_by' => 1],
            ['parameter_category_id' => 1, 'name' => 'Dinding Kedap Air', 'created_by' => 1],
            ['parameter_category_id' => 2, 'name' => 'Lokasi Bebas dari Longsor', 'created_by' => 1],
            ['parameter_category_id' => 3, 'name' => 'Tersedia Toilet', 'created_by' => 1],
            ['parameter_category_id' => 4, 'name' => 'Ventilasi Memadai', 'created_by' => 1],
            ['parameter_category_id' => 5, 'name' => 'Air Minum Layak Konsumsi', 'created_by' => 1],
        ];

        foreach ($parameters as $parameter) {
            HouseParameter::create($parameter);
        }
    }
}
