<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'user_management_access',
            'permission_create',
            'permission_edit',
            'permission_show',
            'permission_delete',
            'permission_access',
            'role_create',
            'role_edit',
            'role_show',
            'role_delete',
            'role_access',
            'user_create',
            'user_edit',
            'user_show',
            'user_delete',
            'user_access',
            'ingredient_create',
            'ingredient_edit',
            'ingredient_show',
            'ingredient_delete',
            'ingredient_access',
            'meal_create',
            'meal_edit',
            'meal_show',
            'meal_delete',
            'meal_access',
            'comment_create',
            'comment_edit',
            'comment_show',
            'comment_delete',
            'comment_access',
            'allergen_access',
            'allergen_create',
            'allergen_show',
            'allergen_edit',
            'allergen_delete',
        ];

        foreach ($permissions as $permission)   {
            Permission::create([
                'name' => $permission
            ]);
        }

        // gets all permissions via Gate::before rule; see AuthServiceProvider
        Role::create(['name' => 'Super Admin']);

        $user = Role::create(['name' => 'User']);

        $userPermissions = [
            'ingredient_create',
            'meal_create',
            'meal_edit',
            'meal_show',
            'meal_delete',
            'meal_access',
            'comment_create',
            'comment_edit',
            'comment_show',
            'comment_delete',
            'comment_access',
        ];

        foreach ($userPermissions as $permission)   {
            $user->givePermissionTo($permission);
        }
    }
}
