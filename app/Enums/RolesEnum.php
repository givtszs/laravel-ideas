<?php

namespace App\Enums;

enum RolesEnum: string
{
    case SuperAdmin = 'super-admin';
    case User = 'user';
    case NotebookAdmin = 'notebook-admin';
    case NotebookModerator = 'notebook-moderator';
    case NotebookParticipant = 'notebook-participant';
}
