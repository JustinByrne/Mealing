<?php

namespace App\Http\Livewire\Meals;

use App\Models\Meal;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $search;
    Public $allMeals;
    
    public function render()
    {
        $meals = Meal::with('ratings', 'media')->withCount(['ratings as rating' => function($query) {
            $query->select(DB::raw('coalesce(avg(score),0)'));
        }])->filter()->paginate(15);
        
        return view('livewire.meals.index', compact('meals'));
    }
}
