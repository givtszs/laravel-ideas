<?php

namespace Database\Seeders;

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

        // Create permissions
        $permissions = [
            'role_grant_notebook_moderator',
            'user_remove_from_notebook',
            'idea_delete'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        Role::create(['name' => 'notebook-admin'])
            ->givePermissionTo([
                'role_grant_notebook_moderator',
                'user_remove_from_notebook',
                'idea_delete'
            ]);

        Role::create(['name' => 'notebook-moderator'])
            ->givePermissionTo(['user_remove_from_notebook', 'idea_delete']);
    }
}
