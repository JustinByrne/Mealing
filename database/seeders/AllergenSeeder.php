<?php

namespace Database\Seeders;

use App\Models\Allergen;
use Illuminate\Database\Seeder;

class AllergenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        $data[] = [
            'icon' => 'eicon eicon-circle-cereal',
            'name' => 'Wheat'
        ];
        $data[] = [
            'icon' => 'eicon eicon-circle-gluten',
            'name' => 'Gluten'
        ];
        $data[] = [
            'icon' => 'eicon eicon-circle-milk',
            'name' => 'Milk'
        ];
        $data[] = [
            'icon' => 'eicon eicon-circle-eggs',
            'name' => 'Eggs'
        ];
        $data[] = [
            'icon' => 'eicon eicon-circle-peanuts',
            'name' => 'Peanuts'
        ];
        $data[] = [
            'icon' => 'eicon eicon-circle-nuts',
            'name' => 'Nuts'
        ];
        $data[] = [
            'icon' => 'eicon eicon-circle-crustaceans',
            'name' => 'Crustaceans'
        ];
        $data[] = [
            'icon' => 'eicon eicon-circle-mustard',
            'name' => 'Mustard'
        ];
        $data[] = [
            'icon' => 'eicon eicon-circle-fish',
            'name' => 'Fish'
        ];
        $data[] = [
            'icon' => 'eicon eicon-circle-lupin',
            'name' => 'Lupin'
        ];
        $data[] = [
            'icon' => 'eicon eicon-circle-sesame',
            'name' => 'Sesame'
        ];
        $data[] = [
            'icon' => 'eicon eicon-circle-celery',
            'name' => 'Celery'
        ];
        $data[] = [
            'icon' => 'eicon eicon-circle-soya',
            'name' => 'Soya'
        ];
        $data[] = [
            'icon' => 'eicon eicon-circle-molluscs',
            'name' => 'Molluscs'
        ];
        $data[] = [
            'icon' => 'eicon eicon-circle-so2',
            'name' => 'Sulphur Dioxide'
        ];

        foreach($data as $allergen) {
            Allergen::insert($allergen);
        }
    }
}
