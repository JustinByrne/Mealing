<?php

namespace App\Http\Livewire\Ingredients;

use Livewire\Component;
use App\Models\Ingredient;

class Index extends Component
{
    public $search;
    
    public function render()
    {
        $ingredients = Ingredient::with('meals', 'user')->where('name', 'like', '%' . $this->search . '%')->get();

        return view('livewire.ingredients.index', compact('ingredients'));
    }
}
