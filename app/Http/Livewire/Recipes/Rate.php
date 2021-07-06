<?php

namespace App\Http\Livewire\Recipes;

use App\Models\Rating;
use App\Models\Recipe;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Rate extends Component
{
    public int $recipeId;
    public int $score;
    
    public function render()
    {
        $rating = Rating::where('user_id', Auth::id())->where('recipe_id', $this->recipeId);
        
        if ($rating->count()) {
            $this->score = $rating->first()->score;
        }
        
        return view('livewire.recipes.rate');
    }

    public function rate($rating)
    {
        Rating::updateOrCreate(
            ['user_id' => Auth::id(), 'recipe_id' => $this->recipeId],
            ['score' => $rating]
        );
    }
}
