<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use Carbon\Carbon;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $patients = [
            [
                'nik' => '3201010101010001',
                'name' => 'Budi Santoso',
                'date_of_birth' => '1985-06-15',
                'gender' => 'M',
                'phone_number' => '081234567890',
                'rt' => 3,
                'rw' => 7,
                'address_id' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nik' => '3201020202020002',
                'name' => 'Siti Aminah',
                'date_of_birth' => '1992-08-20',
                'gender' => 'F',
                'phone_number' => '081234567891',
                'rt' => 5,
                'rw' => 2,
                'address_id' => 2,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nik' => '3201030303030003',
                'name' => 'Ahmad Syahputra',
                'date_of_birth' => '1978-02-05',
                'gender' => 'M',
                'phone_number' => '081234567892',
                'rt' => 1,
                'rw' => 4,
                'address_id' => 3,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nik' => '3201040404040004',
                'name' => 'Dewi Lestari',
                'date_of_birth' => '1990-03-25',
                'gender' => 'F',
                'phone_number' => '081234567893',
                'rt' => 8,
                'rw' => 9,
                'address_id' => 4,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nik' => '3201050505050005',
                'name' => 'Eko Prasetyo',
                'date_of_birth' => '1988-12-30',
                'gender' => 'M',
                'phone_number' => '081234567894',
                'rt' => 2,
                'rw' => 5,
                'address_id' => 5,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nik' => '3201060606060006',
                'name' => 'Sri Wahyuni',
                'date_of_birth' => '1995-11-10',
                'gender' => 'F',
                'phone_number' => '081234567895',
                'rt' => 3,
                'rw' => 2,
                'address_id' => 6,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nik' => '3201070707070007',
                'name' => 'Hendra Kusuma',
                'date_of_birth' => '1980-01-22',
                'gender' => 'M',
                'phone_number' => '081234567896',
                'rt' => 4,
                'rw' => 1,
                'address_id' => 7,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nik' => '3201080808080008',
                'name' => 'Fitri Handayani',
                'date_of_birth' => '1998-04-05',
                'gender' => 'F',
                'phone_number' => '081234567897',
                'rt' => 6,
                'rw' => 3,
                'address_id' => 8,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nik' => '3201090909090009',
                'name' => 'Rizki Saputra',
                'date_of_birth' => '1983-09-18',
                'gender' => 'M',
                'phone_number' => '081234567898',
                'rt' => 9,
                'rw' => 7,
                'address_id' => 9,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nik' => '3201101010100010',
                'name' => 'Ayu Lestari',
                'date_of_birth' => '1991-07-12',
                'gender' => 'F',
                'phone_number' => '081234567899',
                'rt' => 10,
                'rw' => 6,
                'address_id' => 10,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($patients as $patient) {
            Patient::create($patient);
        }
    }
}
