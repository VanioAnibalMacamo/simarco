<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        // Nenhuma lógica adicional necessária no construtor
    }

    public function update(User $user, User $model)
    {
        return $user->hasPermissionTo('update', $model);
    }

    public function delete(User $user, User $model)
    {
        return $user->hasPermissionTo('delete', $model);
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create', User::class);
    }
}
