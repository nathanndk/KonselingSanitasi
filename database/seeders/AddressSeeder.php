<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $addresses = [
            ['street' => 'Jalan Diponegoro', 'district_code' => 'D001', 'subdistrict_code' => 'SD001'],
            ['street' => 'Jalan Sudirman', 'district_code' => 'D002', 'subdistrict_code' => 'SD002'],
            ['street' => 'Jalan Gatot Subroto', 'district_code' => 'D003', 'subdistrict_code' => 'SD003'],
            ['street' => 'Jalan Ahmad Yani', 'district_code' => 'D004', 'subdistrict_code' => 'SD004'],
            ['street' => 'Jalan Pemuda', 'district_code' => 'D005', 'subdistrict_code' => 'SD005'],
            ['street' => 'Jalan Gajah Mada', 'district_code' => 'D006', 'subdistrict_code' => 'SD006'],
            ['street' => 'Jalan Diponegoro 2', 'district_code' => 'D007', 'subdistrict_code' => 'SD007'],
            ['street' => 'Jalan Pahlawan', 'district_code' => 'D008', 'subdistrict_code' => 'SD008'],
            ['street' => 'Jalan Dr. Sutomo', 'district_code' => 'D009', 'subdistrict_code' => 'SD009'],
            ['street' => 'Jalan Imam Bonjol', 'district_code' => 'D010', 'subdistrict_code' => 'SD010'],
        ];

        DB::table('address')->insert($addresses);
    }
}
