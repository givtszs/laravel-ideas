<?php

namespace App\Enums;

enum PermissionsEnum: string
{
    case GrantNotebookModerator = 'grant_notebook_moderator';
    case ParticipantDelete = 'participant_delete';
    case IdeaDelete = 'idea_delete';
    case IdeaCreate = 'idea_create';

    /**
     * Get all defined permissions.
     */
    public static function permissions(): array
    {
        return array_column(PermissionsEnum::cases(), 'value');
    }
}
