<?php

namespace App\Http\Livewire\Menus;

use App\Models\Meal;
use Livewire\Component;

class Create extends Component
{
    public $mealIds;
    public $meals;
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
        $this->mealIds = array();
        $this->meals = array();
        
        $ids = Meal::inRandomOrder()->limit(7)->pluck('id')->toArray();

        for ($i = 0; $i < 7; $i++)  {
            array_push($this->mealIds, $ids[$i]);
            array_push($this->meals, Meal::where('id', $this->mealIds[$i])->first());
        }
    }

    public function randomize($day)
    {
        $meal = Meal::inRandomOrder()->whereNotIn('id', $this->mealIds)->first();

        for ($i = 0; $i < 7; $i++)  {
            if ( $i == $day ) {
                continue;
            }

            $this->meals[$i] = Meal::where('id', $this->meals[$i])->first();
        }
        
        $this->meals[$day] = $meal;
        $this->mealIds[$day] = $meal->id;
    }
}
