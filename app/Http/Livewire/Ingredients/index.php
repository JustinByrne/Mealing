<?php

namespace App\Http\Livewire\Ingredients;

use Livewire\Component;
use App\Models\Ingredient;

class Index extends Component
{
    public $search;
    Public $allIngredients;
    
    public function render()
    {
        if ($this->allIngredients) {
            $ingredients = Ingredient::with('meals')->with('user')->where('name', 'like', '%' . $this->search . '%')->get();
        } else {
            $ingredients = \Auth::User()->Ingredients()->with('meals')->with('user')->where('name', 'like', '%' . $this->search . '%')->get();
        }

        return view('livewire.ingredients.index', [
            'ingredients' => $ingredients,
        ]);
    }
}
