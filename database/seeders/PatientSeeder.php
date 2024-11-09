<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;

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
                'address_id' => 1,
                'created_by' => 1,
                'event_id' => 1, // Sesuaikan dengan ID yang ada di tabel health_events
            ],
            [
                'nik' => '3201020202020002',
                'name' => 'Siti Aminah',
                'date_of_birth' => '1992-08-20',
                'gender' => 'F',
                'phone_number' => '081234567891',
                'address_id' => 2,
                'created_by' => 1,
                'event_id' => 1,
            ],
            [
                'nik' => '3201030303030003',
                'name' => 'Ahmad Syahputra',
                'date_of_birth' => '1978-02-05',
                'gender' => 'M',
                'phone_number' => '081234567892',
                'address_id' => 3,
                'created_by' => 1,
                'event_id' => 1,
            ],
        ];

        foreach ($patients as $patient) {
            Patient::create($patient);
        }
    }
}
