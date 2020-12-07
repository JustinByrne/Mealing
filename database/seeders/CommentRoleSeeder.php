<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PermissionRoleTableSeeder;

class CommentRoleSeeder extends Seeder
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
                'id'    => '37',
                'title' => 'comment_create',
            ],
            [
                'id'    => '38',
                'title' => 'comment_edit',
            ],
            [
                'id'    => '39',
                'title' => 'comment_show',
            ],
            [
                'id'    => '40',
                'title' => 'comment_delete',
            ],
            [
                'id'    => '41',
                'title' => 'comment_access',
            ]
        ], 'id');

        $this->call([
            PermissionRoleTableSeeder::class,
        ]);
    }
}
