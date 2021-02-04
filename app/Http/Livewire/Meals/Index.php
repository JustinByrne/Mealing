<?php

namespace App\Http\Livewire\Meals;

use Livewire\Component;
use App\Models\Meal;

class Index extends Component
{
    public $search;
    Public $allMeals;
    
    public function render()
    {
        if ($this->allMeals) {
            $meals = Meal::with('ratings')->with('user')->where('name', 'like', '%' . $this->search . '%')->get();
        } else {
            $meals = \Auth::User()->Meals()->with('ratings')->with('user')->where('name', 'like', '%' . $this->search . '%')->get();
        }
        
        return view('livewire.meals.index', compact('meals'));
    }
}
