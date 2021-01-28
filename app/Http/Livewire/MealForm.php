<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Ingredient;

class MealForm extends Component
{
    public $quantity;
    public $query;
    public $ingredients;
    public $ingredientId;
    public $autocomplete;
    public $inputs;
    public $i;

    /**
     * setting up variable deafults
     * 
     * @return void
     */
    public function mount()
    {
        $this->resetQuery();
        $this->inputs = array();
        $this->i = 0;
    }

    /**
     * reseting query variables
     * 
     * @return void
     */
    public function resetQuery()
    {
        $this->query = '';
        $this->ingredients = array();
        $this->ingredientId = '';
        $this->autocomplete = false;
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
            $this->autocomplete = false;
            $this->ingredients = Ingredient::where('name', 'like', '%' . $this->query . '%')->get()->toArray();
        } else {
            $this->ingredients = array();
        }
    }

    /**
     * change query and ingredientId value on selection
     * 
     * @return void
     */
    public function autocomplete($query, $id)
    {
        $this->query = $query;
        $this->ingredientId = $id;
        $this->autocomplete = true;
    }
}
