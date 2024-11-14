<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HealthCenter;

class HealthCenterSeeder extends Seeder
{
    public function run()
    {
        $healthCenters = [
            ['id' => 1, 'name' => 'Poncol', 'district_code' => 'KC01', 'subdistrict_code' => 'KD01', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Miroto', 'district_code' => 'KC01', 'subdistrict_code' => 'KD10', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Bandarharjo', 'district_code' => 'KC02', 'subdistrict_code' => 'KD16', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Bulu Lor', 'district_code' => 'KC02', 'subdistrict_code' => 'KD20', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Halmahera', 'district_code' => 'KC03', 'subdistrict_code' => 'KD25', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Bugangan', 'district_code' => 'KC03', 'subdistrict_code' => 'KD29', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'Karangdoro', 'district_code' => 'KC03', 'subdistrict_code' => 'KD30', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'Pandanaran', 'district_code' => 'KC04', 'subdistrict_code' => 'KD35', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'name' => 'Lamper Tengah', 'district_code' => 'KC04', 'subdistrict_code' => 'KD41', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'name' => 'Karangayu', 'district_code' => 'KC05', 'subdistrict_code' => 'KD45', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'name' => 'Lebdosari', 'district_code' => 'KC05', 'subdistrict_code' => 'KD46', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'name' => 'Manyaran', 'district_code' => 'KC05', 'subdistrict_code' => 'KD53', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'name' => 'Krobokan', 'district_code' => 'KC05', 'subdistrict_code' => 'KD56', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'name' => 'Ngemplak Simongan', 'district_code' => 'KC05', 'subdistrict_code' => 'KD59', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'name' => 'Gayamsari', 'district_code' => 'KC06', 'subdistrict_code' => 'KD61', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'name' => 'Candilama', 'district_code' => 'KC07', 'subdistrict_code' => 'KD69', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'name' => 'Kagok', 'district_code' => 'KC07', 'subdistrict_code' => 'KD71', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'name' => 'Pegandan', 'district_code' => 'KC08', 'subdistrict_code' => 'KD74', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'name' => 'Genuk', 'district_code' => 'KC09', 'subdistrict_code' => 'KD83', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'name' => 'Bangetayu', 'district_code' => 'KC09', 'subdistrict_code' => 'KD90', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'name' => 'Tlogosari Kulon', 'district_code' => 'KC10', 'subdistrict_code' => 'KD96', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'name' => 'Tlogosari Wetan', 'district_code' => 'KC10', 'subdistrict_code' => 'KD100', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'name' => 'Kedungmundu', 'district_code' => 'KC11', 'subdistrict_code' => 'KD108', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'name' => 'Rowosari', 'district_code' => 'KC11', 'subdistrict_code' => 'KD115', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 25, 'name' => 'Ngesrep', 'district_code' => 'KC12', 'subdistrict_code' => 'KD120', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 26, 'name' => 'Padangsari', 'district_code' => 'KC12', 'subdistrict_code' => 'KD123', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 27, 'name' => 'Srondol', 'district_code' => 'KC12', 'subdistrict_code' => 'KD126', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 28, 'name' => 'Pudak Payung', 'district_code' => 'KC12', 'subdistrict_code' => 'KD129', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 29, 'name' => 'Gunungpati', 'district_code' => 'KC13', 'subdistrict_code' => 'KD131', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 30, 'name' => 'Sekaran', 'district_code' => 'KC13', 'subdistrict_code' => 'KD142', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 31, 'name' => 'Mijen', 'district_code' => 'KC14', 'subdistrict_code' => 'KD147', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 32, 'name' => 'Karang Malang', 'district_code' => 'KC14', 'subdistrict_code' => 'KD157', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 33, 'name' => 'Tambakaji', 'district_code' => 'KC15', 'subdistrict_code' => 'KD161', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 34, 'name' => 'Purwoyoso', 'district_code' => 'KC15', 'subdistrict_code' => 'KD163', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 35, 'name' => 'Ngaliyan', 'district_code' => 'KC15', 'subdistrict_code' => 'KD165', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 36, 'name' => 'Mangkang', 'district_code' => 'KC16', 'subdistrict_code' => 'KD171', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 37, 'name' => 'Karanganyar', 'district_code' => 'KC16', 'subdistrict_code' => 'KD176', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 38, 'name' => 'Plamongansari', 'district_code' => 'KC10', 'subdistrict_code' => 'KD105', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 39, 'name' => 'Bulusan', 'district_code' => 'KC11', 'subdistrict_code' => 'KD119', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($healthCenters as $attributes) {
            HealthCenter::firstOrCreate(['subdistrict_code' => $attributes['subdistrict_code']], $attributes);
        }
    }
}
