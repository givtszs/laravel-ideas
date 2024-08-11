<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Permission\Models\Role;

class NotebookParticipant extends Pivot
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Get a role assigned to the participant.
     */
    public function getRole(): ?Role
    {
        return Role::firstWhere('id', $this->role_id);
    }
}
