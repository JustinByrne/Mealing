<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleTableSeeder;
use Database\Seeders\CommentRoleSeeder;
use Database\Seeders\RoleUserTableSeeder;
use Database\Seeders\PermissionTableSeeder;
use Database\Seeders\AllergenPermissionSeeder;
use Database\Seeders\PermissionRoleTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleTableSeeder::class,
            PermissionTableSeeder::class,
            PermissionRoleTableSeeder::class,
            RoleUserTableSeeder::class,
            CommentRoleSeeder::class,
            AllergenPermissionSeeder::class,
        ]);
    }
}
