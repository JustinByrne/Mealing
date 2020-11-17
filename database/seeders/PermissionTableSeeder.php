<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::upsert([
            [
                'id'    => '1',
                'title' => 'user_management_access',
            ],
            [
                'id'    => '2',
                'title' => 'permission_create',
            ],
            [
                'id'    => '3',
                'title' => 'permission_edit',
            ],
            [
                'id'    => '4',
                'title' => 'permission_show',
            ],
            [
                'id'    => '5',
                'title' => 'permission_delete',
            ],
            [
                'id'    => '6',
                'title' => 'permission_access',
            ],
            [
                'id'    => '7',
                'title' => 'role_create',
            ],
            [
                'id'    => '8',
                'title' => 'role_edit',
            ],
            [
                'id'    => '9',
                'title' => 'role_show',
            ],
            [
                'id'    => '10',
                'title' => 'role_delete',
            ],
            [
                'id'    => '11',
                'title' => 'role_access',
            ],
            [
                'id'    => '12',
                'title' => 'user_create',
            ],
            [
                'id'    => '13',
                'title' => 'user_edit',
            ],
            [
                'id'    => '14',
                'title' => 'user_show',
            ],
            [
                'id'    => '15',
                'title' => 'user_delete',
            ],
            [
                'id'    => '16',
                'title' => 'user_access',
            ],
            [
                'id'    => '17',
                'title' => 'serving_create',
            ],
            [
                'id'    => '18',
                'title' => 'serving_edit',
            ],
            [
                'id'    => '19',
                'title' => 'serving_show',
            ],
            [
                'id'    => '20',
                'title' => 'serving_delete',
            ],
            [
                'id'    => '21',
                'title' => 'serving_access',
            ],
            [
                'id'    => '22',
                'title' => 'timing_create',
            ],
            [
                'id'    => '23',
                'title' => 'timing_edit',
            ],
            [
                'id'    => '24',
                'title' => 'timing_show',
            ],
            [
                'id'    => '25',
                'title' => 'timing_delete',
            ],
            [
                'id'    => '26',
                'title' => 'timing_access',
            ],
            [
                'id'    => '27',
                'title' => 'ingredient_create',
            ],
            [
                'id'    => '28',
                'title' => 'ingredient_edit',
            ],
            [
                'id'    => '29',
                'title' => 'ingredient_show',
            ],
            [
                'id'    => '30',
                'title' => 'ingredient_delete',
            ],
            [
                'id'    => '31',
                'title' => 'ingredient_access',
            ],
            [
                'id'    => '32',
                'title' => 'meal_create',
            ],
            [
                'id'    => '33',
                'title' => 'meal_edit',
            ],
            [
                'id'    => '34',
                'title' => 'meal_show',
            ],
            [
                'id'    => '35',
                'title' => 'meal_delete',
            ],
            [
                'id'    => '36',
                'title' => 'meal_access',
            ]
            ], 'id');
    }
}
