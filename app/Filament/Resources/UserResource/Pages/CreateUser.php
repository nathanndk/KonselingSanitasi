<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Ensure User model is imported

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    // Override handleRecordCreation to match the signature
    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Hash password before storing
        $data['password'] = Hash::make($data['password']);

        // Create the user record
        $user = User::create($data);

        // Assign role if present in form data
        if (!empty($data['role'])) {
            $user->assignRole($data['role']);
        }

        // Assign permissions if present (optional)
        if (!empty($data['permissions'])) {
            $user->givePermissionTo($data['permissions']);
        }

        // Return the created user model
        return $user;
    }

    // Redirect after creating user
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
