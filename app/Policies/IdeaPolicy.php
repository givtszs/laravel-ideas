<?php

namespace App\Policies;

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

    public function update(User $user, Idea $idea): bool
    {
        return $user->id === $idea->user_id;
    }

    public function delete(User $user, Idea $idea): bool
    {
        return $user->id === $idea->user_id;
    }
}
