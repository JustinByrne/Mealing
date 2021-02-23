<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class AllergenPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::find(1);
        
        $permissions = [
            'allergen_access',
            'allergen_create',
            'allergen_show',
            'allergen_edit',
            'allergen_delete',
        ];

        foreach ($permissions as $permission){
            $new = Permission::create([
                'title' => $permission,
            ]);

            $admin->permissions()->attach($new->id);
        }
    }
}
