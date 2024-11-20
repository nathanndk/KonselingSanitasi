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
            $this->createUserWithRole(
                'Puskesmas', // Role
                Str::slug($healthCenter->name, '_') . '@puskesmas.com', // Email
                Str::slug($healthCenter->name, '_'), // Username
                RoleUser::Puskesmas->value, // Role Enum Value
                $healthCenter->id // Health Center ID
            );
        }
    }

    /**
     * Create a user with a specific role.
     *
     * @param string $role
     * @param string $email
     * @param string $username
     * @param string $roleEnumValue
     * @param int|null $healthCenterId
     * @return void
     */
    private function createUserWithRole($role, $email, $username, $roleEnumValue, $healthCenterId = null)
    {
        $user = User::factory()->create([
            'username' => $username,
            'name' => ucfirst($role) . ' User',
            'email' => $email,
            'password' => bcrypt('password'),
            'role' => $roleEnumValue,
            'nik' => '1234567890123' . rand(10, 99),
            'date_of_birth' => now()->subYears(30)->toDateString(),
            'gender' => 'L',
            'health_center_id' => $healthCenterId,
        ]);

        $user->assignRole($role); // Assign role to the user
    }
}
