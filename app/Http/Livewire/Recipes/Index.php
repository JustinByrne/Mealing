<?php

namespace App\Http\Livewire\Recipes;

use App\Models\Recipe;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $search;
    Public $allRecipes;
    
    public function render()
    {
        $recipes = Recipe::with('ratings', 'media')->withCount(['ratings as rating' => function($query) {
            $query->select(DB::raw('coalesce(avg(score),0)'));
        }])->filter()->paginate(15);
        
        return view('livewire.recipes.index', compact('recipes'));
    }
}
