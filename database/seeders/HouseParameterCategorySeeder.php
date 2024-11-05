<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HouseParameterCategory;

class HouseParameterCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Struktur Bangunan', 'created_by' => 1],
            ['name' => 'Kondisi Lingkungan', 'created_by' => 1],
            ['name' => 'Fasilitas Sanitasi', 'created_by' => 1],
            ['name' => 'Kualitas Udara', 'created_by' => 1],
            ['name' => 'Sumber Air Minum', 'created_by' => 1],
        ];

        foreach ($categories as $category) {
            HouseParameterCategory::create($category);
        }
    }
}
