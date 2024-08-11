<?php

namespace Database\Seeders;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (PermissionsEnum::permissions() as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Define the 'notebook-admin' role and its permissions
        $notebookAdminPermissions = [
            PermissionsEnum::GrantNotebookModerator->value,
            PermissionsEnum::ParticipantDelete->value,
            PermissionsEnum::IdeaDelete->value,
        ];

        Role::create(['name' => RolesEnum::NotebookAdmin->value])->syncPermissions($notebookAdminPermissions);

        // Define the 'notebook-moderator' role and its permissions
        $notebookModeratorPermissions = [
            PermissionsEnum::ParticipantDelete->value,
            PermissionsEnum::IdeaDelete->value,
        ];

        Role::create(['name' => RolesEnum::NotebookModerator->value])->syncPermissions($notebookModeratorPermissions);
    }
}
