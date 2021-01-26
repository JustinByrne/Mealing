<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Ingredient;

class MealForm extends Component
{
    public $quantity;
    public $ingredient;
    public $query;
    public $ingredients;
    public $inputs;
    public $i;

    /**
     * setting up variable deafults
     * 
     * @return void
     */
    public function mount()
    {
        $this->query = '';
        $this->ingredients = array();
        $this->inputs = array();
        $this->i = 0;
    }

    /**
     * getting the view
     * 
     * @return view
     */
    public function render()
    {
        return view('livewire.meal-form');
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

    /**
     * get all the ingredients from the query
     * 
     * @return void
     */
    public function updatedQuery()
    {
        if ($this->query != '') {
            $this->ingredients = Ingredient::where('name', 'like', '%' . $this->query . '%')->get()->toArray();
        } else {
            $this->ingredients = array();
        }
    }
}
