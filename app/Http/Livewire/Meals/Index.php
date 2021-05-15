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
        $meals = Meal::with('ratings', 'media')->filter()->paginate(15);
        
        return view('livewire.meals.index', compact('meals'));
    }
}
