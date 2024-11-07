<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\District;

class DistrictSeeder extends Seeder
{
    public function run(): void
    {
        $districts = [
            ['id' => 1, 'district_code' => 'KC01', 'district_name' => 'Semarang Tengah', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'district_code' => 'KC02', 'district_name' => 'Semarang Utara', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'district_code' => 'KC03', 'district_name' => 'Semarang Timur', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'district_code' => 'KC04', 'district_name' => 'Semarang Selatan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'district_code' => 'KC05', 'district_name' => 'Semarang Barat', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'district_code' => 'KC06', 'district_name' => 'Gayamsari', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'district_code' => 'KC07', 'district_name' => 'Candisari', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'district_code' => 'KC08', 'district_name' => 'Gajahmungkur', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'district_code' => 'KC09', 'district_name' => 'Genuk', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'district_code' => 'KC10', 'district_name' => 'Pedurungan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'district_code' => 'KC11', 'district_name' => 'Tembalang', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'district_code' => 'KC12', 'district_name' => 'Banyumanik', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'district_code' => 'KC13', 'district_name' => 'Gunungpati', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'district_code' => 'KC14', 'district_name' => 'Mijen', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'district_code' => 'KC15', 'district_name' => 'Ngaliyan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'district_code' => 'KC16', 'district_name' => 'Tugu', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'district_code' => 'xxx', 'district_name' => 'Luar Kota', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($districts as $districtData) {
            District::firstOrCreate(['district_code' => $districtData['district_code']], $districtData);
        }
    }
}
