<?php

namespace App\Http\Livewire\Recipes;

use App\Models\Rating;
use App\Models\Recipe;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Rate extends Component
{
    public Recipe $recipe;
    
    public function render()
    {
        return view('livewire.recipes.rate');
    }

    public function rate($rating)
    {
        Rating::updateOrCreate(
            ['user_id' => Auth::id(), 'recipe_id' => $this->recipe->id],
            ['score' => $rating]
        );
    }
}
