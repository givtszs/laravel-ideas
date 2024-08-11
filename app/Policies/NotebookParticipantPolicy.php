<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\NotebookParticipant;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Spatie\Permission\Models\Role;

class NotebookParticipantPolicy
{
    private $notebookAdminRoleId;

    public function before(): ?bool
    {
        $this->notebookAdminRoleId = Role::firstWhere('name', RolesEnum::NotebookAdmin->value)->id;
        return null;
    }

    /**
     * Determine whether the user can remove a participant from the notebook.
     */
    public function remove(User $user, NotebookParticipant $userParticipant, NotebookParticipant $participantToRemove): bool
    {
        $isSameUser = $user->id === $userParticipant->user_id && $user->id === $participantToRemove->user_id;
        if ($isSameUser || $participantToRemove->role_id === $this->notebookAdminRoleId) {
            return false;
        }

        return $userParticipant->getRole()?->hasPermissionTo(PermissionsEnum::ParticipantDelete) ?? false;
    }

    /**
     * Determine whether the user can grant the Moderator role to a participant.
     */
    public function makeModerator(User $user, NotebookParticipant $userParticipant, NotebookParticipant $targetParticipant): bool
    {
        $isSameUser = $user->id === $userParticipant->user_id && $user->id === $targetParticipant->user_id;
        if ($isSameUser || $targetParticipant->role_id === $this->notebookAdminRoleId || $targetParticipant->role_id !== null) {
            return false;
        }

        return $userParticipant->getRole()?->hasPermissionTo(PermissionsEnum::GrantNotebookModerator) ?? false;
    }
}
