<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HealthCenter;

class HealthCenterSeeder extends Seeder
{
    public function run()
    {
        $healthCenters = [
            ['id' => 1, 'name' => 'Poncol', 'kc_code' => 'KC01', 'p_code' => 'P01', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Miroto', 'kc_code' => 'KC02', 'p_code' => 'P02', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Bandarharjo', 'kc_code' => 'KC02', 'p_code' => 'P03', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Bulu Lor', 'kc_code' => 'KC02', 'p_code' => 'P04', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Halmahera', 'kc_code' => 'KC03', 'p_code' => 'P05', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Bugangan', 'kc_code' => 'KC03', 'p_code' => 'P06', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'Karangdoro', 'kc_code' => 'KC03', 'p_code' => 'P07', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'Pandanaran', 'kc_code' => 'KC04', 'p_code' => 'P08', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'name' => 'Lamper Tengah', 'kc_code' => 'KC04', 'p_code' => 'P09', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'name' => 'Karangayu', 'kc_code' => 'KC05', 'p_code' => 'P10', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'name' => 'Lebdosari', 'kc_code' => 'KC05', 'p_code' => 'P11', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'name' => 'Manyaran', 'kc_code' => 'KC05', 'p_code' => 'P12', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'name' => 'Krobokan', 'kc_code' => 'KC05', 'p_code' => 'P13', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'name' => 'Ngemplak Simongan', 'kc_code' => 'KC05', 'p_code' => 'P14', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'name' => 'Gayamsari', 'kc_code' => 'KC06', 'p_code' => 'P15', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'name' => 'Candilama', 'kc_code' => 'KC07', 'p_code' => 'P16', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'name' => 'Kagok', 'kc_code' => 'KC07', 'p_code' => 'P17', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'name' => 'Pegandan', 'kc_code' => 'KC08', 'p_code' => 'P18', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'name' => 'Genuk', 'kc_code' => 'KC09', 'p_code' => 'P19', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'name' => 'Bangetayu', 'kc_code' => 'KC09', 'p_code' => 'P20', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'name' => 'Tlogosari Kulon', 'kc_code' => 'KC10', 'p_code' => 'P21', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'name' => 'Tlogosari Wetan', 'kc_code' => 'KC10', 'p_code' => 'P22', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'name' => 'Kedungmundu', 'kc_code' => 'KC11', 'p_code' => 'P23', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'name' => 'Rowosari', 'kc_code' => 'KC11', 'p_code' => 'P24', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 25, 'name' => 'Ngesrep', 'kc_code' => 'KC12', 'p_code' => 'P25', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 26, 'name' => 'Padangsari', 'kc_code' => 'KC12', 'p_code' => 'P26', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 27, 'name' => 'Srondol', 'kc_code' => 'KC12', 'p_code' => 'P27', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 28, 'name' => 'Pudak Payung', 'kc_code' => 'KC12', 'p_code' => 'P28', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 29, 'name' => 'Gunungpati', 'kc_code' => 'KC13', 'p_code' => 'P29', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 30, 'name' => 'Sekaran', 'kc_code' => 'KC13', 'p_code' => 'P30', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 31, 'name' => 'Mijen', 'kc_code' => 'KC14', 'p_code' => 'P31', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 32, 'name' => 'Karang Malang', 'kc_code' => 'KC14', 'p_code' => 'P32', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 33, 'name' => 'Tambakaji', 'kc_code' => 'KC15', 'p_code' => 'P33', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 34, 'name' => 'Purwoyoso', 'kc_code' => 'KC15', 'p_code' => 'P34', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 35, 'name' => 'Ngaliyan', 'kc_code' => 'KC15', 'p_code' => 'P35', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 36, 'name' => 'Mangkang', 'kc_code' => 'KC16', 'p_code' => 'P36', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 37, 'name' => 'Karanganyar', 'kc_code' => 'KC16', 'p_code' => 'P37', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 38, 'name' => 'Plamongansari', 'kc_code' => 'KC10', 'p_code' => 'P38', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 39, 'name' => 'Bulusan', 'kc_code' => 'KC11', 'p_code' => 'P39', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($healthCenters as $attributes) {
            HealthCenter::firstOrCreate(['p_code' => $attributes['p_code']], $attributes);
        }
    }
}
