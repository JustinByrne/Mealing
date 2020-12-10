<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Meal;

class Meals extends Component
{
    public $search;
    Public $allMeals;
    
    public function render()
    {
        if ($this->allMeals) {
            $meals = Meal::where('name', 'like', '%' . $this->search . '%')->get();
        } else {
            $meals = \Auth::User()->Meals()->where('name', 'like', '%' . $this->search . '%')->get();
        }
        
        return view('livewire.meals', compact('meals'));
    }
}
