<?php
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Mengembalikan nilai boolean sesuai tipe pengembalian yang diharapkan
        return $user->hasRole(['Admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        // Contoh: Hanya admin atau pengguna yang sama yang dapat melihat
        return $user->hasRole('Admin') || $user->id === $model->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Contoh: Hanya admin yang bisa membuat user baru
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Contoh: Hanya admin atau pengguna itu sendiri yang bisa memperbarui data mereka
        return $user->hasRole('Admin') || $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Contoh: Hanya admin yang bisa menghapus user
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        // Contoh: Hanya admin yang bisa me-restore user
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        // Contoh: Hanya admin yang bisa menghapus permanen user
        return $user->hasRole('Admin');
    }
}
