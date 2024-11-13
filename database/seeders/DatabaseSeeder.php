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
            'View Posts',
            'Create Posts',
            'Edit Posts',
            'Delete Posts',
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
            'Admin' => ['View Posts', 'Create Posts', 'Edit Posts', 'Delete Posts', 'View Users', 'Create Users', 'Edit Users', 'Delete Users'],
            'Kader' => ['View Posts', 'Create Posts'],
            'Petugas' => ['View Posts'],
            'Puskesmas' => ['View Posts'],
            'Dinas Kesehatan' => ['View Posts'],
        ];

        foreach ($rolesPermissions as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($permissions);
        }

        // Seed users with roles
        $adminUser = User::factory()->create([
            'username' => 'admin_user',
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
        $this->createUserWithRole('Kader', 'kader@user.com', 'kader_user', RoleUser::Kader->value);
        $this->createUserWithRole('Petugas', 'petugas@user.com', 'petugas_user', RoleUser::Petugas->value);
        $this->createUserWithRole('Puskesmas', 'puskesmas@user.com', 'puskesmas_user', RoleUser::Puskesmas->value);
        $this->createUserWithRole('Dinas Kesehatan', 'dinkes@user.com', 'dinkes_user', RoleUser::DinasKesehatan->value);

        // Call additional seeders
        $this->call([
            DistrictSeeder::class,
            SubdistrictSeeder::class,
            HealthEventSeeder::class,
            AddressSeeder::class,
            PdamConditionSeeder::class,
            PdamParameterCategorySeeder::class,
            PDAMParameterSeeder::class,
            HouseConditionSeeder::class,
            HouseParameterCategorySeeder::class,
            HouseParameterSeeder::class,
            PatientSeeder::class,
            SanitationConditionSeeder::class,
            HealthCenterSeeder::class,
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
