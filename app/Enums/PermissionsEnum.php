<?php

namespace App\Enums;

enum PermissionsEnum: string
{
    case GrantNotebookModerator = 'grant_notebook_moderator';
    case ParticipantDelete = 'participant_delete';
    case IdeaCreate = 'idea_create';
    case IdeaEdit = 'idea_edit';
    case IdeaDelete = 'idea_delete';
    // case IdeaView = 'idea_view'; // every user and even guests can view ideas

    /**
     * Get all defined permissions.
     */
    public static function permissions(): array
    {
        return array_column(PermissionsEnum::cases(), 'value');
    }
}
