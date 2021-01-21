<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Ingredient;

class MealForm extends Component
{
    public $quantity, $ingredient;
    public $inputs = array();
    public $i = 0;

    /**
     * getting the view
     * 
     * @return view
     */
    public function render()
    {
        $ingredients = Ingredient::all();
        return view('livewire.meal-form', compact('ingredients'));
    }

    /**
     * adding all input values to array
     * 
     * @return array
     */
    public function add($i)
    {
        $this->inputs['quantity'][$i] = $this->quantity;
        $this->inputs['ingredient'][$i] = $this->ingredient;

        $this->i = $i + 1;
    }
}
