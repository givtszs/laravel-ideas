<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->is_admin) {
            return true;
        }

        return null;
    }

    public function update(User $user, User $userToUpdate): bool
    {
        return $user->is($userToUpdate);
    }

    public function delete(User $user, User $userToUpdate): bool
    {
        return $user->is($userToUpdate);
    }
}
