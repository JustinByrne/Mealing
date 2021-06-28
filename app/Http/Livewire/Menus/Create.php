<?php

namespace App\Http\Livewire\Menus;

use App\Models\Recipe;
use Livewire\Component;

class Create extends Component
{
    public $recipeIds;
    public $recipes;
    public $days;

    public function mount()
    {
        $this->days = [
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday',
            'sunday'
        ];
    }

    public function render()
    {
        return view('livewire.menus.create');
    }

    public function randomizeAll()
    {
        $this->recipeIds = array();
        $this->recipes = array();
        
        $ids = Recipe::inRandomOrder()->limit(7)->pluck('id')->toArray();

        for ($i = 0; $i < 7; $i++)  {
            array_push($this->recipeIds, $ids[$i]);
            array_push($this->recipes, Recipe::where('id', $this->recipeIds[$i])->first());
        }
    }

    public function randomize($day)
    {
        $recipe = Recipe::inRandomOrder()->whereNotIn('id', $this->recipeIds)->first();

        for ($i = 0; $i < 7; $i++)  {
            if ( $i == $day ) {
                continue;
            }

            $this->recipes[$i] = Recipe::where('id', $this->recipes[$i])->first();
        }
        
        $this->recipes[$day] = $recipe;
        $this->recipeIds[$day] = $recipe->id;
    }
}
