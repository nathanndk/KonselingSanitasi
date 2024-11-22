<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Enums\RoleUser;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Define permissions with capitalized words
        $permissions = [
            'View PDAM',
            'Create PDAM',
            'Edit PDAM',
            'Delete PDAM',
            'View Konseling Sanitasi',
            'Create Konseling Sanitasi',
            'Edit Konseling Sanitasi',
            'Delete Konseling Sanitasi',
            'View Rumah Sehat',
            'Create Rumah Sehat',
            'Edit Rumah Sehat',
            'Delete Rumah Sehat',
            'View Pasien',
            'Create Pasien',
            'Edit Pasien',
            'Delete Pasien',
            'View Jadwal Acara',
            'Create Jadwal Acara',
            'Edit Jadwal Acara',
            'Delete Jadwal Acara',
            'View Users',
            'Create Users',
            'Edit Users',
            'Delete Users'
        ];

        // Create permissions
        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
        }

        // Define roles and assign permissions
        $rolesPermissions = [
            'Admin' => [
                'View PDAM',
                'Create PDAM',
                'Edit PDAM',
                'Delete PDAM',
                'View Konseling Sanitasi',
                'Create Konseling Sanitasi',
                'Edit Konseling Sanitasi',
                'Delete Konseling Sanitasi',
                'View Rumah Sehat',
                'Create Rumah Sehat',
                'Edit Rumah Sehat',
                'Delete Rumah Sehat',
                'View Pasien',
                'Create Pasien',
                'Edit Pasien',
                'Delete Pasien',
                'View Jadwal Acara',
                'Create Jadwal Acara',
                'Edit Jadwal Acara',
                'Delete Jadwal Acara',
                'View Users',
                'Create Users',
                'Edit Users',
                'Delete Users'
            ],
            'Kader' => [
                'View PDAM',
                'Create PDAM',
                'Edit PDAM',
                'Delete PDAM',
                'View Konseling Sanitasi',
                'Create Konseling Sanitasi',
                'Edit Konseling Sanitasi',
                'Delete Konseling Sanitasi',
                'View Rumah Sehat',
                'Edit Rumah Sehat',
                'Delete Rumah Sehat',
                'View Jadwal Acara',
                'Edit Jadwal Acara',
                'View Pasien',
                'Create Pasien',
                'Edit Pasien',
                'Delete Pasien',
            ],
            'Petugas' => [
                'View PDAM',
                'Create PDAM',
                'Edit PDAM',
                'Delete PDAM',
                'View Konseling Sanitasi',
                'Create Konseling Sanitasi',
                'Edit Konseling Sanitasi',
                'Delete Konseling Sanitasi',
                'View Rumah Sehat',
                'Create Rumah Sehat',
                'Edit Rumah Sehat',
                'Delete Rumah Sehat',
                'View Jadwal Acara',
                'Edit Jadwal Acara',
                'View Pasien',
                'Create Pasien',
                'Edit Pasien',
                'Delete Pasien',
            ],
            'Puskesmas' => [
                'View PDAM',
                'Create PDAM',
                'Edit PDAM',
                'Delete PDAM',
                'View Konseling Sanitasi',
                'Create Konseling Sanitasi',
                'Edit Konseling Sanitasi',
                'Delete Konseling Sanitasi',
                'View Rumah Sehat',
                'Create Rumah Sehat',
                'Edit Rumah Sehat',
                'Delete Rumah Sehat',
                'View Pasien',
                'Create Pasien',
                'Edit Pasien',
                'Delete Pasien',
                'View Jadwal Acara',
                'Create Jadwal Acara',
                'Edit Jadwal Acara',
                'Delete Jadwal Acara',
                'View Users',
                'Create Users',
                'Edit Users',
                'Delete Users'
            ],
            'Dinas Kesehatan' => [
                'View PDAM',
                'Create PDAM',
                'Edit PDAM',
                'Delete PDAM',
                'View Konseling Sanitasi',
                'Create Konseling Sanitasi',
                'Edit Konseling Sanitasi',
                'Delete Konseling Sanitasi',
                'View Rumah Sehat',
                'Create Rumah Sehat',
                'Edit Rumah Sehat',
                'Delete Rumah Sehat',
                'View Pasien',
                'Create Pasien',
                'Edit Pasien',
                'Delete Pasien',
                'View Jadwal Acara',
                'Create Jadwal Acara',
                'Edit Jadwal Acara',
                'Delete Jadwal Acara',
                'View Users',
                'Create Users',
                'Edit Users',
                'Delete Users'
            ],
        ];



        foreach ($rolesPermissions as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($permissions);
        }

        // Seed users with roles
        $adminUser = User::factory()->create([
            'username' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role' => RoleUser::Admin->value,
            'nik' => '1234567890123456',
            'date_of_birth' => '1990-01-01',
            'gender' => 'L',
        ]);
        $adminUser->assignRole('Admin');

        // Create additional users for each role
        $this->createUserWithRole('Kader', 'kader@user.com', 'kader', RoleUser::Kader->value);
        $this->createUserWithRole('Petugas', 'petugas@user.com', 'petugas', RoleUser::Petugas->value);
        $this->createUserWithRole('Puskesmas', 'puskesmas@user.com', 'puskesmas', RoleUser::Puskesmas->value);
        $this->createUserWithRole('Dinas Kesehatan', 'dinkes@user.com', 'dinkes', RoleUser::DinasKesehatan->value);

        // Call additional seeders
        $this->call([
            DistrictSeeder::class,
            SubdistrictSeeder::class,
            // HealthEventSeeder::class,
            // AddressSeeder::class,
            // PdamConditionSeeder::class,
            // PdamParameterCategorySeeder::class,
            // PDAMParameterSeeder::class,
            // HouseConditionSeeder::class,
            // HouseParameterCategorySeeder::class,
            // HouseParameterSeeder::class,
            HealthCenterSeeder::class,
            HealthCenterUserSeeder::class,
            // PatientSeeder::class,
            // SanitationConditionSeeder::class,

        ]);


        $this->command->info('Database seeding selesai.');
    }

    private function createUserWithRole($role, $email, $username, $roleEnumValue)
    {
        $user = User::factory()->create([
            'username' => $username,
            'name' => ucfirst($role) . ' User',
            'email' => $email,
            'password' => bcrypt('password'),
            'role' => $roleEnumValue,
            'nik' => '1234567890123' . rand(10, 99),
            'date_of_birth' => '1990-01-01',
            'gender' => 'L',
        ]);
        $user->assignRole($role);
    }
}
