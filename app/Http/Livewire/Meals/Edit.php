<?php

namespace App\Http\Livewire\Meals;

use App\Models\Meal;
use Livewire\Component;

class Edit extends Component
{
    public $i;
    public Meal $meal;
    public $inputs;

    /**
     * adding the ingredients to the array
     * 
     * @return void
     */
    public function mount()
    {
        foreach($this->meal->ingredients as $i=>$ingredient)  {
            $this->inputs[$i]['quantity'] = $ingredient->pivot->quantity;
            $this->inputs[$i]['ingredient'] = $ingredient->name;
            $this->inputs[$i]['ingredientId'] = $ingredient->id;
        }
    }
    
    /**
     * rendering the create form
     * 
     * @return view
     */
    public function render()
    {
        return view('livewire.meals.create');
    }
}
