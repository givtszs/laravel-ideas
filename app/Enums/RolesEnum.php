<?php

namespace App\Enums;

enum RolesEnum: string
{
    case SuperAdmin = 'super-admin';
    case NotebookAdmin = 'notebook-admin';
    case NotebookModerator = 'notebook-moderator';
}
