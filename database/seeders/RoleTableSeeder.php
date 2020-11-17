<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::upsert([
            [
                'id'            =>  '1',
                'title'         =>  'Admin',
                'description'   =>  'Full Administrative User'
            ],
            [
                'id'            =>  '2',
                'title'         =>  'User',
                'description'   =>  'Regular non-admin User'
            ],
        ], 'id', ['title', 'description']);
    }
}
