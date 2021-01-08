<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Ingredient;

class MealForm extends Component
{
    public function render()
    {
        $ingredients = Ingredient::all();
        return view('livewire.meal-form', compact('ingredients'));
    }
}
