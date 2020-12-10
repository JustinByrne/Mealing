<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Ingredient;

class Ingredients extends Component
{
    public $search;
    Public $allIngredients;
    
    public function render()
    {
        if ($this->allIngredients) {
            $ingredients = Ingredient::where('name', 'like', '%' . $this->search . '%')->get();
        } else {
            $ingredients = \Auth::User()->Ingredients()->where('name', 'like', '%' . $this->search . '%')->get();
        }

        return view('livewire.ingredients', [
            'ingredients' => $ingredients,
        ]);
    }
}
