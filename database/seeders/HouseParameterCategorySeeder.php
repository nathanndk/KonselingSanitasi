<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HouseParameterCategory;
use App\Models\User;

class HouseParameterCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if user with ID 1 exists, otherwise use the first user available
        $userId = User::find(1) ? 1 : User::first()->id;

        $categories = [
            // Foreign ID condition 2
            ['name' => 'LOKASI RUMAH', 'updated_by' => $userId, 'house_condition_id' => 2],
            ['name' => 'ATAP RUMAH', 'updated_by' => $userId, 'house_condition_id' => 2],
            ['name' => 'LANGIT-LANGIT RUMAH', 'updated_by' => $userId, 'house_condition_id' => 2],
            ['name' => 'DINDING RUMAH', 'updated_by' => $userId, 'house_condition_id' => 2],
            ['name' => 'RUANGAN UNTUK TEMPAT TIDUR', 'updated_by' => $userId, 'house_condition_id' => 2],
            ['name' => 'RUANGAN UMUM', 'updated_by' => $userId, 'house_condition_id' => 2],
            ['name' => 'LANTAI RUMAH', 'updated_by' => $userId, 'house_condition_id' => 2],
            ['name' => 'VENTILASI RUMAH', 'updated_by' => $userId, 'house_condition_id' => 2],
            ['name' => 'PENCAHAYAAN RUMAH', 'updated_by' => $userId, 'house_condition_id' => 2],

            // Foreign ID condition 3
            ['name' => 'KETERSEDIAAN AIR', 'updated_by' => $userId, 'house_condition_id' => 3],
            ['name' => 'TOILET/SANITASI', 'updated_by' => $userId, 'house_condition_id' => 3],
            ['name' => 'SARANA CTPS', 'updated_by' => $userId, 'house_condition_id' => 3],
            ['name' => 'TEMPAT PENGELOLAAN SAMPAH RUMAH TANGGA', 'updated_by' => $userId, 'house_condition_id' => 3],
            ['name' => 'TEMPAT PENGELOLAAN LIMBAH CAIR RUMAH TANGGA', 'updated_by' => $userId, 'house_condition_id' => 3],
            ['name' => 'KANDANG TERNAK', 'updated_by' => $userId, 'house_condition_id' => 3],

            // Foreign ID condition 5
            ['name' => 'PARAMETER RUANG', 'updated_by' => $userId, 'house_condition_id' => 5],
            ['name' => 'PARAMETER AIR', 'updated_by' => $userId, 'house_condition_id' => 5],
        ];

        foreach ($categories as $category) {
            HouseParameterCategory::create($category);
        }
    }
}
