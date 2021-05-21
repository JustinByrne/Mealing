<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class MenuPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'menu_access',
            'menu_create',
            'menu_show',
            'menu_edit',
            'menu_delete'
        ];

        $user = Role::findByName('User');

        foreach ($permissions as $permission)   {
            Permission::create([
                'name' => $permission
            ]);

            $user->givePermissionTo($permission);
        }
    }
}
