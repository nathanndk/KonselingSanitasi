<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\HealthCenter;
use Illuminate\Support\Str;
use App\Enums\RoleUser;

class HealthCenterUserSeeder extends Seeder
{
    public function run()
    {
        $healthCenters = HealthCenter::all();

        foreach ($healthCenters as $healthCenter) {
            User::firstOrCreate(
                ['username' => Str::slug($healthCenter->name, '_')], // Username dari nama puskesmas
                [
                    'name' => $healthCenter->name,
                    'email' => Str::slug($healthCenter->name, '_') . '@puskesmas.com', // Email dengan format yang sesuai
                    'password' => bcrypt('password123'), // Password default, dapat diganti sesuai kebutuhan
                    'role' => RoleUser::Puskesmas->value,
                    'nik' => '', // Isi sesuai kebutuhan atau buat null jika tidak ada data
                    'date_of_birth' => now()->subYears(25)->format('Y-m-d'), // Tanggal lahir default, sesuaikan jika diperlukan
                    'profile_pic' => null, // Biarkan null jika tidak ada gambar profil
                    'gender' => 'Not Specified', // Isi 'Male' atau 'Female' jika perlu, atau biarkan default ini
                    'health_center_id' => $healthCenter->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
