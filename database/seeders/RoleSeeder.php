<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::upsert([
            ['title' => 'Admin', 'description' => 'Full Administrative User'],
            ['title' => 'User', 'description' => 'Regular non-admin User'],
        ], 'title', ['description']);
    }
}
