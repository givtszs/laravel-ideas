<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\Idea;
use App\Models\User;

class IdeaPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->is_admin) {
            return true;
        }

        return null;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::IdeaCreate);
    }

    public function update(User $user, Idea $idea): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::IdeaEdit) && $user->id === $idea->user_id;
    }

    public function delete(User $user, Idea $idea): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::IdeaDelete) && $user->id === $idea->user_id;
    }
}
